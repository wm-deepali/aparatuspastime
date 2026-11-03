<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Setting;  
use Illuminate\Support\Facades\DB;

trait FinalizesOrderPayment
{


    protected function sendOrderEmails(Order $order): void
    {
        $order->loadMissing([
    'items.product',
    'items.addons',
    'items.imageVariant',
    'items.skuVariant',
    'state',
    'city',
]);

        /*
         |--------------------------------------------------------------------------
         | Order Items HTML
         |--------------------------------------------------------------------------
         */
        $orderItems = '';

        foreach ($order->items as $item) {

            // Thumbnail: image variant > product default image > null (matches admin blade)
            $thumb = null;
            if ($item->imageVariant && $item->imageVariant->image) {
                $thumb = asset('storage/' . $item->imageVariant->image);
            } elseif ($item->product) {
                $thumb = $item->product->display_image;
            }

            $imageHtml = $thumb
                ? "<img src='{$thumb}' alt='{$item->product_name}' style='width:56px;height:56px;object-fit:cover;border-radius:4px;border:1px solid #d0d8d7;display:block;'>"
                : "<span style='display:block;width:56px;height:56px;background:#e8efee;border-radius:4px;border:1px solid #d0d8d7;'></span>";

            // Variant label from selected_attributes snapshot (same logic as admin blade)
            $variantLabel = null;
            if (!empty($item->selected_attributes)) {
                $variantLabel = collect($item->selected_attributes)
                    ->map(function ($value, $key) {
                        if (is_array($value)) {
                            $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                            $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                            return $attrName . ': ' . $attrVal;
                        }
                        return $key . ': ' . $value;
                    })
                    ->join(' · ');
            }

            $variantHtml = $variantLabel
                ? "<div style='font-size:11px;color:#7a9e9c;'>{$variantLabel}</div>"
                : '';

            // SKU: sku variant > snapshot sku > product sku
            $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);
            $skuHtml = $sku
                ? "<div style='font-size:11px;color:#7a9e9c;'>SKU: {$sku}</div>"
                : '';

            // Addons — list each one and fold into the line total
            $addonsTotal = $item->addons->sum('price');
            $lineTotal = ($item->price * $item->quantity) + $addonsTotal;

            $addonsHtml = '';
            if ($item->addons->isNotEmpty()) {
                foreach ($item->addons as $addon) {
                    $addonsHtml .= "<div style='font-size:11px;color:#7a9e9c;'>+ {$addon->detail} (₹" . number_format($addon->price, 2) . ")</div>";
                }
            }

            $orderItems .= "
    <div style='display:table;width:100%;border-bottom:1px solid #e6eae9;padding:14px 0;'>
        <div style='display:table-cell;width:60px;vertical-align:middle;padding-right:14px;'>
            {$imageHtml}
        </div>
        <div style='display:table-cell;vertical-align:middle;'>
            <div style='font-size:13px;font-weight:600;color:#1a1a1a;margin-bottom:3px;'>{$item->product_name}</div>
            {$variantHtml}
            {$skuHtml}
            <div style='font-size:11px;color:#7a9e9c;'>Qty: {$item->quantity}</div>
            {$addonsHtml}
        </div>
        <div style='display:table-cell;vertical-align:middle;text-align:right;font-size:14px;font-weight:700;color:#1F5552;white-space:nowrap;'>
            ₹ " . number_format($lineTotal, 2) . "
        </div>
    </div>
";
        }
        /*
        |--------------------------------------------------------------------------
        | Order Summary HTML
        |--------------------------------------------------------------------------
        */
        $orderSummary = "
        <div style='margin-top:16px;'>
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:13px;color:#666;'>Subtotal</span>
                <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                    ₹ " . number_format($order->subtotal, 2) . "
                </span>
            </div>
    ";

        if ($order->discount > 0) {
            $discountLabel = 'Discount' . ($order->coupon_code ? " ({$order->coupon_code})" : '');
            $orderSummary .= "
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:13px;color:#2e7d32;font-weight:500;'>{$discountLabel}</span>
                <span style='display:table-cell;text-align:right;font-size:13px;color:#2e7d32;font-weight:500;'>
                    − ₹ " . number_format($order->discount, 2) . "
                </span>
            </div>
        ";
        }

        if ($order->shipping_charge > 0) {
            $orderSummary .= "
        <div style='display:table;width:100%;padding:5px 0;'>
            <span style='display:table-cell;font-size:13px;color:#666;'>Shipping</span>
            <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                ₹ " . number_format($order->shipping_charge, 2) . "
            </span>
        </div>
    ";
        }

        if ($order->tax_amount > 0) {

            if ($order->gst_type === 'igst' && $order->igst_amount > 0) {

                $orderSummary .= "
                <div style='display:table;width:100%;padding:5px 0;'>
                    <span style='display:table-cell;font-size:13px;color:#666;'>IGST ({$order->igst_rate}%)</span>
                    <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                        ₹ " . number_format($order->igst_amount, 2) . "
                    </span>
                </div>
            ";

            } else {

                if ($order->cgst_amount > 0) {
                    $orderSummary .= "
                    <div style='display:table;width:100%;padding:5px 0;'>
                        <span style='display:table-cell;font-size:13px;color:#666;'>CGST ({$order->cgst_rate}%)</span>
                        <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                            ₹ " . number_format($order->cgst_amount, 2) . "
                        </span>
                    </div>
                ";
                }

                if ($order->sgst_amount > 0) {
                    $orderSummary .= "
                    <div style='display:table;width:100%;padding:5px 0;'>
                        <span style='display:table-cell;font-size:13px;color:#666;'>SGST ({$order->sgst_rate}%)</span>
                        <span style='display:table-cell;text-align:right;font-size:13px;color:#333;'>
                            ₹ " . number_format($order->sgst_amount, 2) . "
                        </span>
                    </div>
                ";
                }
            }
        }

        $orderSummary .= "
            <hr style='border:none;border-top:1px solid #d4dbd9;margin:10px 0;'>
            <div style='display:table;width:100%;padding:5px 0;'>
                <span style='display:table-cell;font-size:15px;font-weight:600;color:#1a1a1a;'>Grand Total</span>
                <span style='display:table-cell;text-align:right;font-size:16px;font-weight:700;color:#1F5552;'>
                    ₹ " . number_format($order->grand_total, 2) . "
                </span>
            </div>
        </div>
    ";
        /*
        |--------------------------------------------------------------------------
        | Shipping Address HTML
        |--------------------------------------------------------------------------
        */
        $shippingAddress = "
        <div>
            <strong>{$order->customer_name}</strong><br>
            {$order->address_line_1}
    ";

        if (!empty($order->address_line_2)) {
            $shippingAddress .= "<br>{$order->address_line_2}";
        }

        $shippingAddress .= "
            <br>{$order->city?->name}, {$order->state?->name} - {$order->pincode}
            <br>📞 {$order->customer_phone}
        </div>
    ";

        /*
        |--------------------------------------------------------------------------
        | Common Variables
        |--------------------------------------------------------------------------
        */
        $variables = [

            '{customer_name}' => $order->customer_name,

            '{order_number}' => $order->order_number,
            '{order_date}' => $order->created_at->format('d M Y'),
            '{grand_total}' => '₹' . number_format($order->grand_total, 2),

            '{payment_method}' => ucfirst($order->payment_method),
            '{payment_status}' => ucfirst($order->payment_status),
            '{transaction_id}' => $order->transaction_id ?? 'N/A',

            '{order_url}' => route('order.success', $order->id),

            '{order_items}' => $orderItems,
            '{order_summary}' => $orderSummary,
            '{shipping_address}' => $shippingAddress,
        ];

        /*
        |--------------------------------------------------------------------------
        | Customer - Order Confirmed
        |--------------------------------------------------------------------------
        */
        \App\Services\Email\EmailDispatcher::send(
            'order-confirmed',
            $order->customer_email,
            $variables,
            $order->customer_name
        );

        /*
        |--------------------------------------------------------------------------
        | Customer - Payment Received
        |--------------------------------------------------------------------------
        */
        if ($order->payment_status === 'paid') {

            \App\Services\Email\EmailDispatcher::send(
                'payment-received',
                $order->customer_email,
                array_merge($variables, [
                    '{payment_amount}' => '₹' . number_format($order->grand_total, 2),
                    '{transaction_id}' => $order->transaction_id ?? $order->razorpay_payment_id ?? 'N/A',
                    '{invoice_url}' => route('order.success', $order->id),
                ]),
                $order->customer_name
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin - New Order Alert
        |--------------------------------------------------------------------------
        */
        $adminEmail = Setting::first()?->admin_email;

        if ($adminEmail) {

            \App\Services\Email\EmailDispatcher::send(
                'new-order-alert',
                $adminEmail,
                array_merge($variables, [
                    '{admin_order_url}' => route('admin.orders.show', $order->id),
                ])
            );
        }
    }


    protected function deductOrderStock(Order $order): void
    {
        /** @var \App\Services\StockService $stockService */
        $stockService = app(\App\Services\StockService::class);

        $order->loadMissing(['items.product', 'items.stockVariant']);

        foreach ($order->items as $item) {
            $product = $item->product;

            if (!$product)
                continue;

            try {
                $stockService->debit(
                    $product,
                    $item->quantity,
                    'order',
                    $order,               // reference — links history entry to this order
                    null,                 // no admin user, this is a customer action
                    null,                 // no note
                    true,                 // allowNegative: true so an order never fails due to stock race
                    $item->stockVariant   // null if this item has no stock-type variant → falls back to product stock
                );
            } catch (\Exception $e) {
                // Log but don't block the order — stock can be corrected manually
                \Log::warning("Stock debit failed for product {$product->id} on order {$order->id}: " . $e->getMessage());
            }
        }
    }

    protected function logPayment(array $data): void
    {
        try {
            \App\Models\PaymentLog::create($data);
        } catch (\Exception $e) {
            \Log::warning('Payment log write failed: ' . $e->getMessage());
        }
    }

    /**
     * Marks a Razorpay order as paid. Safe to call from both the browser
     * callback and the webhook. Returns the Order if THIS call processed it,
     * or null if it was already paid.
     */
    protected function finalizeRazorpayPayment(
        int $orderId,
        string $paymentId,
        ?string $signature,
        string $triggeredBy,
        ?int $customerId = null
    ): ?Order {
        DB::beginTransaction();

        try {
            $order = Order::with('items')
                ->when($customerId, fn($q) => $q->where('customer_id', $customerId))
                ->lockForUpdate()
                ->findOrFail($orderId);

            if ($order->payment_status === 'paid') {
                DB::commit();
                return null;
            }

            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'transaction_id' => $paymentId,
                'status' => 'processing',
            ]);

            $order->statusHistory()->create([
                'status' => 'processing',
                'previous_status' => 'pending',
                'remarks' => 'Payment received successfully via Razorpay',
                'triggered_by' => $triggeredBy,
            ]);

            \App\Models\Notification::create([
                'customer_id' => $order->customer_id,
                'title' => 'Payment Successful',
                'message' => 'Payment received for order ' . $order->order_number . '. Your order is now being processed.',
                'icon' => 'fa-credit-card',
                'color' => 'success-icon',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => 'processing',
                ],
            ]);

            \App\Models\AdminNotification::notify([
                'type' => 'payment',
                'title' => 'Payment received',
                'message' => "Payment of ₹" . number_format($order->grand_total, 2) . " for order #{$order->order_number} successfully received via Razorpay.",
                'reference' => '#' . $order->order_number,
                'icon' => 'fa-credit-card',
                'url' => route('admin.orders.show', $order->id),
                'link_text' => 'View Order',
            ]);

            if (!$order->invoice) {
                app(\App\Services\InvoiceService::class)->createIfAuto($order);
            }

            $cart = Cart::where('user_id', $order->customer_id)->first();
            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            $this->deductOrderStock($order);

            $this->logPayment([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'gateway' => 'razorpay',
                'payment_id' => $paymentId,
                'amount' => $order->grand_total,
                'method' => 'razorpay',
                'status' => 'captured',
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'meta' => ['razorpay_payment_id' => $paymentId, 'source' => $triggeredBy],
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

               try {
            $this->sendOrderEmails($order);
        } catch (\Throwable $e) {
            \Log::warning("Order emails failed for order {$order->id}: " . $e->getMessage());
        }

        return $order;
    }

}