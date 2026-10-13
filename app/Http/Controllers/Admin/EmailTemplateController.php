<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\SmtpSetting;
use App\Services\Email\EmailDispatcher;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        return view('admin.admin-settings.templates', self::getData());
    }

    /**
     * Supplies $emailTemplates, $emailMeta, $smtpSettings and $emailSamples
     * to the shared message-templates blade.
     */
    public static function getData(): array
    {
        $templates = EmailTemplate::whereIn('event_key', EmailTemplate::$eventKeys)
            ->get()
            ->keyBy('event_key');

        return [
            'emailMeta' => EmailTemplate::eventMeta(),
            'emailTemplates' => $templates,
            'smtpSettings' => SmtpSetting::getInstance(),
            'emailSamples' => self::sampleVars(),
        ];
    }

    /**
     * Sample values for every template variable.
     * Used by the live preview (blade) and by the test email.
     */
    public static function sampleVars(string $email = 'customer@example.com'): array
    {
        // Same $general object the front-end layout uses (admin → General Settings)
        $general = view()->shared('general');

        $appUrl = rtrim(url('/'), '/');
        $storeName = $general?->site_name ?: config('app.name', 'Aparatus Pastime');
        $tagline = $general?->tagline ?: 'Play. Learn. Grow.';
        $logo = $general?->header_logo
            ? asset('storage/' . $general->header_logo)
            : asset('assets/logo.png');
        $supportEmail = $general?->support_email ?: $general?->admin_email ?: 'support@example.com';
        $supportPhone = $general?->phone ?: '+91 00000 00000';

        $navy = '#073B73';
        $orange = '#F58220';

        $thumb = '<span style="display:block;width:56px;height:56px;background:#F0F8FF;border-radius:10px;border:1px solid #d6e8f7;"></span>';

        $orderItems = '
    <div style="display:table;width:100%;border-bottom:1px solid #e8edf2;padding:14px 0;">
        <div style="display:table-cell;width:60px;vertical-align:middle;padding-right:14px;">' . $thumb . '</div>
        <div style="display:table-cell;vertical-align:middle;">
            <div style="font-size:13px;font-weight:700;color:#172B4D;margin-bottom:3px;">Sample Toy Product</div>
            <div style="font-size:11px;color:#7A8795;">Qty: 1</div>
        </div>
        <div style="display:table-cell;vertical-align:middle;text-align:right;font-size:14px;font-weight:800;color:' . $navy . ';white-space:nowrap;">₹ 1,499.00</div>
    </div>
    <div style="display:table;width:100%;border-bottom:1px solid #e8edf2;padding:14px 0;">
        <div style="display:table-cell;width:60px;vertical-align:middle;padding-right:14px;">' . $thumb . '</div>
        <div style="display:table-cell;vertical-align:middle;">
            <div style="font-size:13px;font-weight:700;color:#172B4D;margin-bottom:3px;">Sample Board Game</div>
            <div style="font-size:11px;color:#7A8795;">Qty: 2</div>
        </div>
        <div style="display:table-cell;vertical-align:middle;text-align:right;font-size:14px;font-weight:800;color:' . $navy . ';white-space:nowrap;">₹ 1,800.00</div>
    </div>';

        $orderSummary = '
    <div style="margin-top:16px;">
        <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:13px;color:#465466;">Subtotal</span>
            <span style="display:table-cell;text-align:right;font-size:13px;color:#172B4D;">₹ 3,299.00</span>
        </div>
        <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:13px;color:#2e7d32;font-weight:600;">Discount (PLAY10)</span>
            <span style="display:table-cell;text-align:right;font-size:13px;color:#2e7d32;font-weight:600;">− ₹ 329.00</span>
        </div>
        <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:13px;color:#465466;">Shipping</span>
            <span style="display:table-cell;text-align:right;font-size:13px;color:#172B4D;">Free</span>
        </div>
        <hr style="border:none;border-top:1px solid #d6e8f7;margin:10px 0;">
        <div style="display:table;width:100%;padding:5px 0;">
            <span style="display:table-cell;font-size:15px;font-weight:700;color:#172B4D;">Grand Total</span>
            <span style="display:table-cell;text-align:right;font-size:17px;font-weight:800;color:' . $orange . ';">₹ 2,970.00</span>
        </div>
    </div>';

        return [
            // Customer
            '{customer_name}' => 'Rahul Sharma',
            '{email}' => $email,

            // Store (global)
            '{store_name}' => $storeName,
            '{brand_name}' => $storeName,
            '{logo_url}' => $logo,
            '{tagline}' => $tagline,
            '{shop_url}' => $appUrl . '/shop',
            '{login_url}' => $appUrl . '/user/login',

            // Support (global)
            '{support_email}' => $supportEmail,
            '{support_number}' => $supportPhone,

            // Order
            '{order_number}' => 'ORD-1089',
            '{order_date}' => now()->subDays(4)->format('d M Y'),
            '{shipped_date}' => now()->subDays(2)->format('d M Y'),
            '{delivered_date}' => now()->format('d M Y'),
            '{grand_total}' => '₹2,970',
            '{item_count}' => '3',

            // Payment
            '{payment_method}' => 'UPI',
            '{payment_status}' => 'Paid',
            '{payment_amount}' => '₹2,970',
            '{transaction_id}' => 'TXN8472910',

            // Shipment
            '{courier_name}' => 'Delhivery',
            '{tracking_number}' => 'DEL123456789',
            '{tracking_url}' => $appUrl . '/track/1089',
            '{expected_delivery}' => now()->addDays(3)->format('d M Y'),

            // Cancellation / Refund
            '{cancel_reason}' => 'Out of stock',
            '{refund_amount}' => '₹2,970',
            '{refund_days}' => '5-7',

            // Smart HTML blocks
            '{order_items}' => $orderItems,
            '{order_summary}' => $orderSummary,
            '{shipping_address}' => '<div><strong>Rahul Sharma</strong><br>221B Baker Street<br>Mohali, Punjab - 160055<br>📞 +91-9876543210</div>',

            // Actions
            '{order_url}' => $appUrl . '/user/orders/1089',
            '{review_url}' => $appUrl . '/user/orders/1089',
            '{return_url}' => $appUrl . '/user/orders/1089',
            '{invoice_url}' => $appUrl . '/user/orders/1089/invoice',

            // Coupon
            '{coupon_code}' => 'PLAY10',
            '{discount_value}' => '10%',
            '{expiry_date}' => now()->addDays(30)->format('d M Y'),
            '{store_url}' => $appUrl,

            // Password reset (OTP)
            '{otp}' => '847291',
            '{otp_expiry}' => '10',

            // Admin — new order alert
            '{admin_order_url}' => $appUrl . '/admin/orders/1089',

            // Admin — low stock digest
            '{report_date}' => now()->format('l, d F Y — g:i A'),
            '{total_count}' => '5',
            '{critical_count}' => '2',
            '{low_count}' => '3',
            '{critical_threshold}' => '2',
            '{low_threshold}' => '5',
            '{critical_products}' => '<div style="font-size:12px;font-weight:700;color:#b22222;margin:20px 0 10px">🔴 Out of Stock (≤ 2 units)</div><div>Sample critical product row</div>',
            '{low_products}' => '<div style="font-size:12px;font-weight:700;color:#916a00;margin:20px 0 10px">🟡 Low Stock (≤ 5 units)</div><div>Sample low stock product row</div>',
            '{admin_stock_url}' => $appUrl . '/admin/stock-alerts',
        ];
    }

    /**
     * AJAX save — POST /admin/settings/email-templates/{eventKey}
     */
    public function save(Request $request, string $eventKey): \Illuminate\Http\JsonResponse
    {
        if (!in_array($eventKey, EmailTemplate::$eventKeys)) {
            return response()->json(['success' => false, 'message' => 'Invalid event key.'], 422);
        }

        $validated = $request->validate([
            'enabled' => 'nullable|boolean',
            'from_name' => 'nullable|string|max:100',
            'from_email' => 'nullable|email|max:150',
            'reply_to_name' => 'nullable|string|max:100',
            'reply_to_email' => 'nullable|email|max:150',
            'cc' => 'nullable|email|max:150',
            'subject' => 'nullable|string|max:255',
            'preview_text' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            // extras
            'expiry_minutes' => 'nullable|integer|min:1|max:1440',
            'admin_email' => 'nullable|email|max:150',
            'stock_threshold' => 'nullable|integer|min:1',
        ]);

        $extras = [];
        if ($eventKey === 'password-reset' && isset($validated['expiry_minutes'])) {
            $extras['expiry_minutes'] = $validated['expiry_minutes'];
        }
        if (in_array($eventKey, ['new-order-alert', 'low-stock-alert'])) {
            if (isset($validated['admin_email'])) {
                $extras['admin_email'] = $validated['admin_email'];
            }
            if (isset($validated['stock_threshold'])) {
                $extras['stock_threshold'] = $validated['stock_threshold'];
            }
        }

        $template = EmailTemplate::firstOrNew(['event_key' => $eventKey]);
        $template->fill([
            'enabled' => (bool) ($validated['enabled'] ?? false),
            'from_name' => $validated['from_name'] ?? null,
            'from_email' => $validated['from_email'] ?? null,
            'reply_to_name' => $validated['reply_to_name'] ?? null,
            'reply_to_email' => $validated['reply_to_email'] ?? null,
            'cc' => $validated['cc'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'preview_text' => $validated['preview_text'] ?? null,
            'body' => $validated['body'] ?? null,
            'extra_settings' => !empty($extras) ? $extras : null,
        ]);
        $template->save();

        return response()->json([
            'success' => true,
            'message' => "'{$eventKey}' email template saved.",
        ]);
    }

    /**
     * AJAX test send — POST /admin/settings/email-templates/test
     */
    public function sendTest(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'event_key' => 'required|string',
            'email' => 'required|email',
        ]);

        $eventKey = $request->input('event_key');
        $email = $request->input('email');

        $result = EmailDispatcher::sendTest($eventKey, $email, self::sampleVars($email), 'Test Recipient');

        return response()->json([
            'success' => $result['success'],
            'message' => $result['success']
                ? "Test email sent to {$email}"
                : $result['response'],
        ]);
    }
}