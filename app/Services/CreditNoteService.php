<?php

namespace App\Services;

use App\Models\RefundTransaction;

class CreditNoteService
{
    public static function relations(): array
    {
        return [
            'ndr.order.items.product',
            'ndr.order.items.addons',
            'ndr.order.items.skuVariant',
            'ndr.order.invoice',
            'order.items.product',
            'order.items.addons',
            'order.items.skuVariant',
            'order.invoice',
            'orderReturn.order.invoice',
            'orderReturn.orderItem.product',
            'orderReturn.orderItem.addons',
            'orderReturn.orderItem.skuVariant',
        ];
    }

    /**
     * Single source of truth for a credit note.
     * Used by the GST report rows AND the PDF/preview.
     */
    public function build(RefundTransaction $refund): array
    {
        if ($refund->ndr_id) {
            // NDR -> RTO / cancelled: entire order tax reversed
            $order = $refund->ndr->order;
            $items = $order->items;

            $taxable = (float) $order->subtotal;
            $cgst = (float) $order->cgst_amount;
            $sgst = (float) $order->sgst_amount;
            $igst = (float) $order->igst_amount;
            $tax = (float) $order->tax_amount;
            $reason = $refund->ndr->status === 'rto' ? 'RTO' : 'Cancelled (Failed Delivery)';

        } elseif ($refund->order_return_id) {
            // Single returned item: proportional tax
            $orderReturn = $refund->orderReturn;
            $order = $orderReturn->order;
            $item = $orderReturn->orderItem;
            $items = collect([$item]);

            $itemBase = ((float) $item->price * $item->quantity) + (float) $item->addons->sum('price');
            $proportion = $order->subtotal > 0 ? $itemBase / (float) $order->subtotal : 0;

            $taxable = $itemBase;
            $tax = (float) $order->tax_amount * $proportion;
            $cgst = (float) $order->cgst_amount * $proportion;
            $sgst = (float) $order->sgst_amount * $proportion;
            $igst = (float) $order->igst_amount * $proportion;
            $reason = 'Returned';

        } else {
            // Cancelled order refund (CancelledRefundController)
            $order = $refund->order;
            $items = $order->items;

            $proportion = $order->grand_total > 0
                ? min(1, (float) $refund->amount / (float) $order->grand_total)
                : 1;

            $taxable = (float) $order->subtotal * $proportion;
            $cgst = (float) $order->cgst_amount * $proportion;
            $sgst = (float) $order->sgst_amount * $proportion;
            $igst = (float) $order->igst_amount * $proportion;
            $tax = (float) $order->tax_amount * $proportion;
            $reason = 'Cancelled';
        }

        return [
            'refund_id' => $refund->id,
            'credit_note_no' => 'CN-' . str_pad($refund->id, 4, '0', STR_PAD_LEFT),
            'order' => $order,
            'items' => $items,
            'order_number' => $order->order_number,
            'order_id' => $order->id,
            'product' => $items->map(fn($i) => $i->product->name ?? $i->product_name)->filter()->implode(', ') ?: '—',
            'reason' => $reason,
            'refund_date' => $refund->created_at,
            'taxable' => $taxable,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'igst' => $igst,
            'tax' => $tax,
            'refund_amount' => (float) $refund->amount,
            'utr_id' => $refund->utr_id,
        ];
    }
}