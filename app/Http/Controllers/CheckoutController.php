<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\State;
use App\Models\City;
use App\Models\Setting;
use App\Models\OrderItem;
use App\Traits\LogsApiCalls;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use App\Services\StockAlertService;
use App\Http\Requests\AddressRequest;
use App\Traits\FinalizesOrderPayment;

class CheckoutController extends Controller
{
    use LogsApiCalls, FinalizesOrderPayment;

    // Inject in constructor
    public function __construct(protected StockAlertService $alertService)
    {
    }

    public function checkout()
    {
        $customer = auth('customer')->user();

        $cart = Cart::with([
            'items.product.images',
            'items.product.category',
            'items.priceVariant',
            'items.imageVariant',
            'items.addons',
        ])
            ->where('user_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart');
        }

        $cart->recalculateTotals();
        $cart->refresh();
        $cart->load([
            'items.product.images',
            'items.product.category',
            'items.priceVariant',
            'items.imageVariant',
            'items.addons',
        ]);

        $addresses = $customer->addresses()
            ->with(['state', 'city'])
            ->orderByDesc('is_default')
            ->get();

        $defaultAddress = $addresses->firstWhere('is_default', true);

        $states = State::orderBy('name')->get();

        $beginCheckoutScript = \App\Services\Tracking\PixelTracker::beginCheckoutScript($cart);

        return view(
            'front-pages.checkout',
            compact(
                'cart',
                'customer',
                'addresses',
                'defaultAddress',
                'states',
                'beginCheckoutScript'
            )
        );
    }

    public function storeAddress(AddressRequest $request)
    {
        $customer = auth('customer')->user();
        $data = $request->validated();

        DB::transaction(function () use ($customer, $data) {
            CustomerAddress::where('customer_id', $customer->id)->update(['is_default' => 0]);

            CustomerAddress::create([
                'customer_id' => $customer->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address_line_1' => $data['address_line_1'],
                'address_line_2' => $data['address_line_2'] ?? null,
                'state_id' => $data['state_id'],
                'city_id' => $data['city_id'],
                'pincode' => $data['pincode'],
                'address_type' => $data['address_type'] ?? 'home',
                'is_default' => 1,
            ]);
        });

        $cart = Cart::where('user_id', $customer->id)->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        return response()->json(['success' => true]);
    }

    public function cities(State $state)
    {
        return response()->json(
            City::where('state_id', $state->id)->orderBy('name')->get(['id', 'name'])
        );
    }

    public function changeDefaultAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:customer_addresses,id'
        ]);

        $customer = auth('customer')->user();

        CustomerAddress::where(
            'customer_id',
            $customer->id
        )->update([
                    'is_default' => 0
                ]);

        CustomerAddress::where(
            'id',
            $request->address_id
        )
            ->where('customer_id', $customer->id)
            ->update([
                'is_default' => 1
            ]);

        $cart = Cart::where(
            'user_id',
            $customer->id
        )->first();

        if ($cart) {
            $cart->recalculateTotals();
        }

        return response()->json([
            'success' => true
        ]);
    }


    public function placeOrder(Request $request)
    {
        $customer = auth('customer')->user();

        $request->validate([
            'payment_method' => 'required|in:cod,razorpay',
        ]);

        /*
        |--------------------------------------------------------------------------
        | COD is managed by admin (Settings → cod_enabled)
        |--------------------------------------------------------------------------
        */
        if ($request->payment_method === 'cod' && !Setting::first()?->cod_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Cash on Delivery is currently unavailable.',
            ], 422);
        }

        $address = null;

        /*
        |--------------------------------------------------------------------------
        | Existing Address
        |--------------------------------------------------------------------------
        */

        if ($request->filled('address_id')) {
            $address = CustomerAddress::where('customer_id', $customer->id)
                ->find($request->address_id);

            if (!$address) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected address was not found. Please choose another address.',
                ], 422);
            }

            // GST is calculated from the default address, so make the chosen one the default
            if (!$address->is_default) {
                CustomerAddress::where('customer_id', $customer->id)->update(['is_default' => 0]);
                $address->update(['is_default' => 1]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create Address If Not Exists
        |--------------------------------------------------------------------------
        */

        if (!$address) {

            $request->validate(
                collect((new AddressRequest)->rules())->except(['address_type', 'is_default'])->all()
            );

            CustomerAddress::where(
                'customer_id',
                $customer->id
            )->update([
                        'is_default' => 0
                    ]);

            $address = CustomerAddress::create([

                'customer_id' => $customer->id,

                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,

                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,

                'state_id' => $request->state_id,
                'city_id' => $request->city_id,

                'pincode' => $request->pincode,

                'address_type' => 'home',

                'is_default' => 1,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Recalculate GST Using New Address
            |--------------------------------------------------------------------------
            */

            $cart = Cart::where(
                'user_id',
                $customer->id
            )->first();

            if ($cart) {

                $cart->recalculateTotals();
                $cart->refresh();
            }
        }

        $cart = Cart::with([
            'items.product',
            'items.addons',
        ])
            ->where('user_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->count() == 0) {

            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        DB::beginTransaction();

        try {

            $order = Order::create([

                'customer_id' => $customer->id,
                'address_id' => $address->id,

                'order_number' =>
                    'ORD-' . strtoupper(uniqid()),

                'customer_name' => $address->name,
                'customer_email' => $address->email,
                'customer_phone' => $address->phone,

                'address_line_1' => $address->address_line_1,
                'address_line_2' => $address->address_line_2,

                'state_id' => $address->state_id,
                'city_id' => $address->city_id,
                'pincode' => $address->pincode,

                'coupon_code' => $cart->coupon_code,

                'subtotal' => $cart->subtotal,
                'discount' => $cart->discount,
                'shipping_charge' => $cart->shipping_charge,
                'tax_amount' => $cart->tax_amount,
                'grand_total' => $cart->grand_total,

                'gst_type' => $cart->gst_type,

                'cgst_rate' => $cart->cgst_rate,
                'sgst_rate' => $cart->sgst_rate,
                'igst_rate' => $cart->igst_rate,

                'cgst_amount' => $cart->cgst_amount,
                'sgst_amount' => $cart->sgst_amount,
                'igst_amount' => $cart->igst_amount,

                'payment_method' => $request->payment_method,

                'payment_status' =>
                    $request->payment_method == 'cod'
                    ? 'pending'
                    : 'pending',

                'status' => 'pending',
            ]);

            $order->statusHistory()->create([
                'status' => 'pending',
                'previous_status' => null,
                'remarks' => 'Order placed successfully',
                'triggered_by' => 'Customer',
            ]);

            // Admin notification
            \App\Models\AdminNotification::notify([
                'type' => 'order',
                'title' => 'New order placed',
                'message' => "{$order->customer_name} placed a new order worth ₹" . number_format($order->grand_total, 2) . " ({$order->items()->count()} items).",
                'reference' => '#' . $order->order_number,
                'icon' => 'fa-shopping-bag',
                'url' => route('admin.orders.show', $order->id),
                'link_text' => 'View Order',
            ]);

            \App\Models\Notification::create([
                'customer_id' => $customer->id,
                'title' => 'Order Placed',
                'message' => 'Your order ' . $order->order_number . ' has been placed successfully.',
                'icon' => 'fa-cart-shopping',
                'color' => 'order-icon',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => 'pending',
                ],
            ]);

            foreach ($cart->items as $item) {

                $orderItem = OrderItem::create([

                    'order_id' => $order->id,

                    'product_id' => $item->product_id,

                    'price_variant_id' => $item->price_variant_id,
                    'image_variant_id' => $item->image_variant_id,
                    'stock_variant_id' => $item->stock_variant_id,
                    'sku_variant_id' => $item->sku_variant_id,

                    'selected_attributes' => $item->selected_attributes,

                    'product_name' =>
                        $item->product->name ?? 'Product',

                    'quantity' => $item->quantity,

                    'price' => $item->price,

                    'total' => $item->total,
                ]);

                // Carry the cart item's addon snapshot over to the order item.
                foreach ($item->addons as $addon) {
                    $orderItem->addons()->create([
                        'addon_id' => $addon->addon_id,
                        'detail' => $addon->detail,
                        'price' => $addon->price,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | COD Order
            |--------------------------------------------------------------------------
            */

            if ($request->payment_method == 'cod') {

                app(\App\Services\InvoiceService::class)->createIfAuto($order);

                $cart->items()->delete();
                $cart->delete();

                $this->deductOrderStock($order);

                $this->logPayment([
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'gateway' => 'cod',
                    'payment_id' => null,
                    'amount' => $order->grand_total,
                    'method' => 'cod',
                    'status' => 'pending',
                    'customer_name' => $order->customer_name,
                    'customer_email' => $order->customer_email,
                ]);

                DB::commit();

                // Meta CAPI purchase event, dispatched after commit so order is guaranteed saved
                \App\Jobs\SendMetaCapiPurchase::dispatch(
                    $order->id,
                    $request->ip(),
                    $request->userAgent(),
                    $request->cookie('_fbp'),
                    $request->cookie('_fbc'),
                );

                $this->sendOrderEmails($order);

                return response()->json([
                    'success' => true,
                    'type' => 'cod',
                    'message' => 'Order placed successfully.',
                    'redirect_url' => route(
                        'order.success',
                        $order->id
                    )
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Razorpay Order
            |--------------------------------------------------------------------------
            */

            $paymentSetting = PaymentSetting::first();

            $keyId = $paymentSetting->live_mode
                ? $paymentSetting->live_key_id
                : $paymentSetting->test_key_id;

            $keySecret = $paymentSetting->live_mode
                ? $paymentSetting->live_key_secret
                : $paymentSetting->test_key_secret;

            $api = new Api(
                $keyId,
                $keySecret
            );

            $razorpayPayload = [

                'receipt' => $order->order_number,

                'amount' =>
                    round($order->grand_total * 100),

                'currency' => 'INR',

                'payment_capture' => 1
            ];

            $apiStartTime = microtime(true);

            try {

                $razorpayOrder = $api->order->create($razorpayPayload);

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'orders',
                    'service' => 'Razorpay',
                    'status_code' => 200,
                    'response_time_ms' => (int) round((microtime(true) - $apiStartTime) * 1000),
                    'request_payload' => $razorpayPayload,
                    'response_payload' => $razorpayOrder->toArray(),
                ]);

            } catch (\Exception $e) {

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'orders',
                    'service' => 'Razorpay',
                    'status_code' => $e->getCode() ?: 500,
                    'response_time_ms' => (int) round((microtime(true) - $apiStartTime) * 1000),
                    'request_payload' => $razorpayPayload,
                    'error_message' => $e->getMessage(),
                ]);

                throw $e;
            }

            $order->update([
                'razorpay_order_id' =>
                    $razorpayOrder['id']
            ]);

            $this->logPayment([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'gateway' => 'razorpay',
                'payment_id' => $razorpayOrder['id'],
                'amount' => $order->grand_total,
                'method' => null,
                'status' => 'created',
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'meta' => $razorpayOrder->toArray(),
            ]);

            DB::commit();

            return response()->json([

                'success' => true,

                'type' => 'razorpay',

                'order_id' => $order->id,

                'razorpay_order_id' =>
                    $razorpayOrder['id'],

                'amount' =>
                    round($order->grand_total * 100),

                'key' => $keyId,

                'customer_name' =>
                    $order->customer_name,

                'customer_email' =>
                    $order->customer_email,

                'customer_phone' =>
                    $order->customer_phone,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function razorpaySuccess(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
        ]);

        try {
            // Only the customer who owns this order can complete its payment
            $order = Order::where('customer_id', auth('customer')->id())
                ->findOrFail($request->order_id);

            // Already processed (double submit / refresh / webhook got there first)
            if ($order->payment_status === 'paid') {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('order.success', $order->id),
                ]);
            }

            // The Razorpay order must be the one created for this order
            if ($order->razorpay_order_id !== $request->razorpay_order_id) {
                throw new \Exception('Payment does not match this order.');
            }

            /* Verify Signature */
            $paymentSetting = PaymentSetting::first();

            $keyId = $paymentSetting->live_mode
                ? $paymentSetting->live_key_id
                : $paymentSetting->test_key_id;

            $keySecret = $paymentSetting->live_mode
                ? $paymentSetting->live_key_secret
                : $paymentSetting->test_key_secret;

            $api = new Api($keyId, $keySecret);

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ];

            $verifyStartTime = microtime(true);

            try {
                $api->utility->verifyPaymentSignature($attributes);

                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'payment/verify',
                    'service' => 'Razorpay',
                    'status_code' => 200,
                    'response_time_ms' => (int) round((microtime(true) - $verifyStartTime) * 1000),
                    'request_payload' => $attributes,
                ]);
            } catch (\Exception $e) {
                $this->logApiCall([
                    'method' => 'POST',
                    'endpoint' => 'payment/verify',
                    'service' => 'Razorpay',
                    'status_code' => $e->getCode() ?: 400,
                    'response_time_ms' => (int) round((microtime(true) - $verifyStartTime) * 1000),
                    'request_payload' => $attributes,
                    'error_message' => $e->getMessage(),
                ]);

                throw $e;
            }

            /* Finalize (transaction, status, invoice, cart, stock, emails — all in trait) */
            $finalized = $this->finalizeRazorpayPayment(
                $order->id,
                $request->razorpay_payment_id,
                $request->razorpay_signature,
                'Customer (Browser Callback)',
                auth('customer')->id()
            );

            // Only fire Meta CAPI if THIS call processed the payment (not the webhook)
            if ($finalized) {
                \App\Jobs\SendMetaCapiPurchase::dispatch(
                    $finalized->id,
                    $request->ip(),
                    $request->userAgent(),
                    $request->cookie('_fbp'),
                    $request->cookie('_fbc'),
                );
            }

            return response()->json([
                'success' => true,
                'redirect_url' => route('order.success', $order->id),
            ]);

        } catch (\Exception $e) {

            $failedOrder = Order::find($request->order_id);

            $this->logPayment([
                'order_id' => $request->order_id ?? null,
                'order_number' => $failedOrder?->order_number,
                'gateway' => 'razorpay',
                'payment_id' => $request->razorpay_payment_id ?? null,
                'amount' => $failedOrder?->grand_total ?? 0,
                'method' => 'razorpay',
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'meta' => $request->only(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature']),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function orderSuccess(Order $order)
    {
        // Customers can only view their own order confirmation
        abort_unless($order->customer_id === auth('customer')->id(), 403);

        // Pixel/GA purchase event — rendered as an inline script tag on the thank-you view
        $purchaseScript = \App\Services\Tracking\PixelTracker::purchaseScript($order);

        return view(
            'front-pages.thank-you',
            compact('order', 'purchaseScript')
        );
    }



}