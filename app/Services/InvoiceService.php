<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceSetting;
use App\Models\Order;
use App\Http\Controllers\Admin\AdminSettingController;

class InvoiceService
{
    // Setting row na ho to purana behaviour (auto) hi rakhte hain
    public function autoEnabled(): bool
    {
        $setting = InvoiceSetting::first();

        return $setting ? (bool) $setting->auto_generate_invoice : true;
    }

    // Checkout ke liye: sirf tab banao jab auto ON ho
    public function createIfAuto(Order $order): ?Invoice
    {
        return $this->autoEnabled() ? $this->createForOrder($order) : null;
    }

    // Auto aur manual dono yahi use karenge
    public function createForOrder(Order $order): Invoice
    {
        if ($existing = Invoice::where('order_id', $order->id)->first()) {
            return $existing; // duplicate invoice nahi banegi
        }

        $order->loadMissing(['city', 'state']);

        return Invoice::create([
            'order_id'       => $order->id,
            'invoice_number' => AdminSettingController::generateInvoiceNumber(),
            'invoice_date'   => now()->toDateString(),

            'customer_name'  => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,

            'billing_address' => collect([
                $order->address_line_1,
                $order->address_line_2,
                $order->city?->name ?? '',
                $order->state?->name ?? '',
                $order->pincode,
            ])->filter()->implode(', '),

            'subtotal'        => $order->subtotal,
            'discount'        => $order->discount,
            'shipping_charge' => $order->shipping_charge,
            'tax_amount'      => $order->tax_amount,
            'grand_total'     => $order->grand_total,

            'gst_type'    => $order->gst_type,
            'cgst_rate'   => $order->cgst_rate,
            'sgst_rate'   => $order->sgst_rate,
            'igst_rate'   => $order->igst_rate,
            'cgst_amount' => $order->cgst_amount,
            'sgst_amount' => $order->sgst_amount,
            'igst_amount' => $order->igst_amount,

            'status' => 'generated',
        ]);
    }
}