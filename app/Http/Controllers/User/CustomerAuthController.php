<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\AuthLog;
use App\Services\GeoIpService;
use Jenssegers\Agent\Agent;

class CustomerAuthController extends Controller
{
    public function registerForm(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('user.dashboard');
        }

        $this->rememberIntended($request);

        return view('user.register');
    }

    public function loginForm(Request $request)
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('user.dashboard');
        }

        $this->rememberIntended($request);

        return view('user.login');
    }

    public function register(Request $request)
    {
        // alternate_mobile is optional, but if filled must still be a valid format.
        // For AJAX (modal) requests Laravel returns these errors as 422 JSON automatically.
        $validated = $request->validate(
            [
                'name' => ['required', 'max:100', 'regex:/^[A-Za-z\s]+$/'],
                'email' => ['required', 'email', 'unique:customers,email'],
                'mobile' => ['required', 'regex:/^[6-9]\d{9}$/', 'unique:customers,mobile'],
                'alternate_mobile' => ['nullable', 'regex:/^[6-9]\d{9}$/'],
                'password' => ['required', 'min:8', 'confirmed'],
                'terms' => ['accepted'],
            ],
            [
                'name.regex' => 'Name should contain only letters.',
                'mobile.regex' => 'Enter a valid Indian mobile number.',
                'alternate_mobile.regex' => 'Enter a valid alternate mobile number.',
                'password.confirmed' => 'Password and confirm password do not match.',
                'terms.accepted' => 'Please accept the Terms & Conditions to continue.',
            ]
        );

        $customer = Customer::create(\Illuminate\Support\Arr::except($validated, ['terms']));

        \App\Models\AdminNotification::notify([
            'type' => 'customer',
            'title' => 'New customer registered',
            'message' => "{$customer->name} ({$customer->email}) created a new account.",
            'icon' => 'fa-user-plus',
            'url' => route('admin.customers.show', $customer->id),
            'link_text' => 'View Customer',
        ]);

        \App\Services\Email\EmailDispatcher::send(
            'welcome',
            $customer->email,
            [
                '{customer_name}' => $customer->name,
            ]
        );

        // Capture the guest session id BEFORE regenerating it, so the guest
        // cart/wishlist tied to this session can still be found and merged.
        $guestSessionId = session()->getId();

        Auth::guard('customer')->login($customer);

        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

        $request->session()->regenerate();

        // Modal (AJAX) signup — the page reloads / redirects on the client
        if ($request->expectsJson()) {
            session()->flash('success', 'Registration completed successfully.');
            session()->flash('fire_signup_event', 'email_password');

            return response()->json([
                'status' => true,
                'message' => 'Registration completed successfully.',
                'redirect' => $this->postAuthRedirect($request),
            ]);
        }

        // Sends the customer back to wherever they came from (e.g. the cart
        // page) instead of always landing on the dashboard after signup.
        return redirect()
            ->intended(route('user.dashboard'))
            ->with('success', 'Registration completed successfully.')
            ->with('fire_signup_event', 'email_password');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');
        $meta = $this->captureLoginMeta($request);

        $guestSessionId = session()->getId();

        if (Auth::guard('customer')->attempt($credentials, $remember)) {

            $customer = Auth::guard('customer')->user();

            $guestSessionId = session()->getId();

            $this->mergeGuestCart($customer, $guestSessionId);
            $this->mergeGuestWishlist($customer, $guestSessionId);

            $request->session()->regenerate();

            AuthLog::create(array_merge([
                'customer_id' => $customer->id,
                'user_type' => 'customer',
                'email' => $customer->email,
                'event' => 'login',
                'status' => 'success',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ], $meta));

            if ($request->expectsJson()) {
                session()->flash('success', 'Login successful.');
                session()->flash('fire_login_event', true);

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful.',
                    'redirect' => $this->postAuthRedirect($request),
                ]);
            }

            return redirect()
                ->intended(route('user.dashboard'))
                ->with('success', 'Login successful.')
                ->with('fire_login_event', true);
        }

        AuthLog::create(array_merge([
            'user_type' => 'customer',
            'email' => $credentials['email'],
            'event' => 'login_failed',
            'status' => 'failed',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'error_message' => 'Invalid email or password',
        ], $meta));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Invalid email or password.',
                'errors' => ['email' => ['Invalid email or password.']],
            ], 422);
        }

        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ]);
    }

    public function redirectToGoogle(Request $request)
    {
        // Lets the modal's "Continue with Google" return to the current page
        $this->rememberIntended($request);

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('user.login')
                ->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        $customer = Customer::firstOrCreate(
            [
                'email' => $googleUser->email,
            ],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'password' => bcrypt(str()->random(20)),
                'mobile' => time(),
                'alternate_mobile' => time() + 1,
            ]
        );

        // Only fires for a genuinely new signup, not existing Google login
        if ($customer->wasRecentlyCreated) {
            \App\Models\AdminNotification::notify([
                'type' => 'customer',
                'title' => 'New customer registered',
                'message' => "{$customer->name} ({$customer->email}) signed up via Google.",
                'icon' => 'fa-user-plus',
                'url' => route('admin.customers.show', $customer->id),
                'link_text' => 'View Customer',
            ]);
        }

        $isNewCustomer = $customer->wasRecentlyCreated;

        Auth::guard('customer')->login($customer);

        $meta = $this->captureLoginMeta(request());

        AuthLog::create(array_merge([
            'customer_id' => $customer->id,
            'user_type' => 'customer',
            'email' => $customer->email,
            'event' => 'login',
            'status' => 'success',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $meta));

        $guestSessionId = session()->getId();

        $this->mergeGuestCart($customer, $guestSessionId);
        $this->mergeGuestWishlist($customer, $guestSessionId);

        request()->session()->regenerate();

        // Flash for session-based tracking, same as email/password paths above
        if ($isNewCustomer) {
            session()->flash('fire_signup_event', 'google_oauth');
        } else {
            session()->flash('fire_login_event', true);
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer) {
            // Close out the open session's duration, mirroring the admin logout flow
            $lastLogin = AuthLog::where('customer_id', $customer->id)
                ->where('event', 'login')
                ->success()
                ->whereNull('logged_out_at')
                ->latest('id')
                ->first();

            if ($lastLogin) {
                $lastLogin->update([
                    'logged_out_at' => now(),
                    'duration_seconds' => $lastLogin->created_at->diffInSeconds(now()),
                ]);
            }
            AuthLog::create([
                'customer_id' => $customer->id,
                'user_type' => 'customer',
                'email' => $customer->email,
                'event' => 'logout',
                'status' => 'success',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }

    /**
     * Only allow same-site targets (a local path or the same host) so a crafted
     * ?redirect= value can't send customers to another website after login.
     */
    private function safeTarget(?string $target, Request $request): ?string
    {
        $target = trim((string) $target);

        if ($target === '' || str_contains($target, '\\')) {
            return null;
        }

        $host = parse_url($target, PHP_URL_HOST);

        $isLocalPath = $host === null && str_starts_with($target, '/') && !str_starts_with($target, '//');
        $isSameHost = $host !== null && strcasecmp($host, $request->getHost()) === 0;

        return ($isLocalPath || $isSameHost) ? $target : null;
    }

    /**
     * Remember where to send the customer after login/signup (page flow).
     */
    private function rememberIntended(Request $request): void
    {
        $target = $this->safeTarget($request->query('redirect'), $request);

        if ($target) {
            session(['url.intended' => $target]);
        }
    }

    /**
     * Where the modal should send the customer after a successful AJAX
     * login/signup: the page they were on (or the link they clicked), else
     * any stored intended URL, else the dashboard.
     */
    private function postAuthRedirect(Request $request): string
    {
        return $this->safeTarget($request->input('redirect'), $request)
            ?? redirect()->intended(route('user.dashboard'))->getTargetUrl();
    }

    /**
     * Parse device/browser/OS from the user agent and resolve a best-effort
     * geo location from the IP. Used across login (password) and Google OAuth.
     */
    private function captureLoginMeta(Request $request): array
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $deviceType = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : 'Desktop');
        $geo = GeoIpService::lookup($request->ip());

        return [
            'device_type' => $deviceType,
            'browser' => trim($agent->browser() . ' ' . $agent->version($agent->browser())),
            'platform' => trim($agent->platform() . ' ' . $agent->version($agent->platform())),
            'city' => $geo['city'],
            'country' => $geo['country'],
            'isp' => $geo['isp'],
        ];
    }

    private function mergeGuestCart(Customer $customer, $guestSessionId)
    {
        $guestCart = Cart::with('items.addons')
            ->where('session_id', $guestSessionId)
            ->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::where('user_id', $customer->id)->first();

        // Customer has no cart yet: the guest cart simply becomes theirs (keeps its coupon too)
        if (!$userCart) {
            $guestCart->update(['user_id' => $customer->id]);
            $guestCart->recalculateTotals();
            return;
        }

        if ($guestCart->id == $userCart->id) {
            return;
        }

        foreach ($guestCart->items as $item) {

            // Same rule as CartController::add(): customized lines (with addons) never merge
            $existingItem = $item->addons->isEmpty()
                ? CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $item->product_id)
                    ->where('price_variant_id', $item->price_variant_id)
                    ->where('image_variant_id', $item->image_variant_id)
                    ->where('stock_variant_id', $item->stock_variant_id)
                    ->where('sku_variant_id', $item->sku_variant_id)
                    ->doesntHave('addons')
                    ->get()
                    ->first(fn($candidate) => $candidate->selected_attributes === $item->selected_attributes)
                : null;

            if ($existingItem) {

                $existingItem->quantity += $item->quantity;
                $existingItem->total = $existingItem->quantity * $existingItem->price;
                $existingItem->save();

            } else {

                $newItem = CartItem::create([
                    'cart_id' => $userCart->id,
                    'product_id' => $item->product_id,
                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,
                    'selected_attributes' => $item->selected_attributes,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ]);

                foreach ($item->addons as $addon) {
                    $newItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }
        }

        $guestCart->items()->each(fn($item) => $item->addons()->delete());
        $guestCart->items()->delete();
        $guestCart->delete();

        $userCart->recalculateTotals();
    }

    private function mergeGuestWishlist(Customer $customer, $guestSessionId)
    {
        $guestWishlistItems = Wishlist::where(
            'session_id',
            $guestSessionId
        )->get();

        if ($guestWishlistItems->isEmpty()) {
            return;
        }

        foreach ($guestWishlistItems as $item) {

            $exists = Wishlist::where(
                'customer_id',
                $customer->id
            )
                ->where(
                    'product_id',
                    $item->product_id
                )
                ->exists();

            if (!$exists) {

                Wishlist::create([
                    'customer_id' => $customer->id,
                    'session_id' => null,
                    'product_id' => $item->product_id,
                    'expires_at' => $item->expires_at,
                ]);
            }
        }

        Wishlist::where(
            'session_id',
            session()->getId()
        )->delete();
    }

}