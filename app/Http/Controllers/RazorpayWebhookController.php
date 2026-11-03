<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentSetting;
use App\Traits\FinalizesOrderPayment;
use Illuminate\Http\Request;

class RazorpayWebhookController extends Controller
{
    use FinalizesOrderPayment;

    public function handle(Request $request)
    {
        $body = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature');

        $setting = PaymentSetting::first();
        $secret = $setting?->live_mode ? $setting->live_webhook_secret : $setting?->test_webhook_secret;

        if (!$secret || !$signature) {
            \Log::warning('Razorpay webhook: secret or signature missing');
            return response()->json(['message' => 'Not configured'], 400);
        }

        if (!hash_equals(hash_hmac('sha256', $body, $secret), $signature)) {
            \Log::warning('Razorpay webhook: invalid signature');
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $event = $request->input('event');
        $payment = $request->input('payload.payment.entity', []);
        $rzpOrderId = $payment['order_id'] ?? $request->input('payload.order.entity.id');

        if (!$rzpOrderId) {
            return response()->json(['message' => 'ignored']);
        }

        $order = Order::where('razorpay_order_id', $rzpOrderId)->first();

        if (!$order) {
            return response()->json(['message' => 'order not found']); // 200 so Razorpay stops retrying
        }

        try {
            switch ($event) {
                case 'payment.captured':
                case 'order.paid':
                    // Amount must match what we asked Razorpay to charge
                    if (isset($payment['amount']) && (int) $payment['amount'] !== (int) round($order->grand_total * 100)) {
                        \Log::warning("Razorpay webhook: amount mismatch for order {$order->id}");
                        $this->logPayment([
                            'order_id' => $order->id,
                            'order_number' => $order->order_number,
                            'gateway' => 'razorpay',
                            'payment_id' => $payment['id'] ?? null,
                            'amount' => ($payment['amount'] ?? 0) / 100,
                            'method' => $payment['method'] ?? null,
                            'status' => 'failed',
                            'error_message' => 'Webhook amount mismatch',
                        ]);
                        break;
                    }

                    $this->finalizeRazorpayPayment(
                        $order->id,
                        $payment['id'] ?? '',
                        null,
                        'Razorpay Webhook'
                    );
                    break;

                case 'payment.failed':
                    if ($order->payment_status !== 'paid') {
                        $this->logPayment([
                            'order_id' => $order->id,
                            'order_number' => $order->order_number,
                            'gateway' => 'razorpay',
                            'payment_id' => $payment['id'] ?? null,
                            'amount' => $order->grand_total,
                            'method' => $payment['method'] ?? 'razorpay',
                            'status' => 'failed',
                            'customer_name' => $order->customer_name,
                            'customer_email' => $order->customer_email,
                            'error_message' => $payment['error_description'] ?? 'Payment failed',
                            'meta' => $payment['error_code'] ?? null ? ['error_code' => $payment['error_code']] : null,
                        ]);
                    }
                    break;
            }
        } catch (\Throwable $e) {
            \Log::error('Razorpay webhook failed: ' . $e->getMessage());
            return response()->json(['message' => 'error'], 500); // Razorpay will retry
        }

        return response()->json(['message' => 'ok']);
    }
}