<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [

        'user_id',
        'session_id',

        'total_amount',

        'coupon_id',
        'coupon_code',

        'subtotal',
        'discount',
        'shipping_charge',
        'tax_amount',

        'gst_type',

        'cgst_rate',
        'sgst_rate',
        'igst_rate',

        'cgst_amount',
        'sgst_amount',
        'igst_amount',

        'grand_total',
    ];

    public function items()
    {
        return $this->hasMany(
            CartItem::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            Customer::class
        );
    }

    public function coupon()
    {
        return $this->belongsTo(
            Coupon::class
        );
    }

    public function recalculateTotals()
    {
        $invoiceSetting = InvoiceSetting::first();

        $subtotal = $this->items()->sum('total');

        $discount = $this->discount ?? 0;

        $taxableAmount = max(
            $subtotal - $discount,
            0
        );

        $taxAmount = 0;
        $grandTotal = $taxableAmount;
        $displaySubtotal = $subtotal;

        $gstType = null;

        $cgstRate = 0;
        $sgstRate = 0;
        $igstRate = 0;

        $cgstAmount = 0;
        $sgstAmount = 0;
        $igstAmount = 0;

        if (
            $invoiceSetting &&
            $invoiceSetting->business_type === 'registered'
        ) {
            if ($this->user_id) {

                $defaultAddress = CustomerAddress::where(
                    'customer_id',
                    $this->user_id
                )
                    ->where('is_default', 1)
                    ->first();

                if (
                    $defaultAddress &&
                    $defaultAddress->state_id ==
                    $invoiceSetting->company_state
                ) {

                    $gstType = 'cgst_sgst';

                    $cgstRate = $invoiceSetting->cgst ?? 0;
                    $sgstRate = $invoiceSetting->sgst ?? 0;

                    $gstPercentage = $cgstRate + $sgstRate;

                } else {

                    $gstType = 'igst';

                    $igstRate = $invoiceSetting->igst ?? 0;

                    $gstPercentage = $igstRate;
                }

            } else {

                $gstType = 'cgst_sgst';

                $cgstRate = $invoiceSetting->cgst ?? 0;
                $sgstRate = $invoiceSetting->sgst ?? 0;

                $gstPercentage = $cgstRate + $sgstRate;
            }

            if ($invoiceSetting->tax_type === 'exclusive') {

                $taxAmount = ($taxableAmount * $gstPercentage) / 100;

                $grandTotal = $taxableAmount + $taxAmount;

                $displaySubtotal = $subtotal;

            } else {

                $taxAmount = ($taxableAmount * $gstPercentage) / (100 + $gstPercentage);

                $grandTotal = $taxableAmount;

                $displaySubtotal = $subtotal - $taxAmount;
            }

            if ($gstType === 'cgst_sgst') {

                $cgstAmount = round($taxAmount / 2, 2);
                $sgstAmount = round($taxAmount / 2, 2);

            } else {

                $igstAmount = round($taxAmount, 2);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Shipping — added after tax (shipping is not taxed here).
        | Uses the raw items total minus discount, NOT the stored subtotal,
        | because stored subtotal has tax stripped out in inclusive mode.
        |--------------------------------------------------------------------------
        */
        $shipping = \App\Services\ShippingCalculator::forCart($this, $taxableAmount);

        $shippingCharge = $shipping['charge'];
        $grandTotal += $shippingCharge;

        $this->update([

            'subtotal' => round($displaySubtotal, 2),
            'discount' => round($discount, 2),
            'shipping_charge' => round($shippingCharge, 2),

            'gst_type' => $gstType,

            'cgst_rate' => $cgstRate,
            'sgst_rate' => $sgstRate,
            'igst_rate' => $igstRate,

            'cgst_amount' => $cgstAmount,
            'sgst_amount' => $sgstAmount,
            'igst_amount' => $igstAmount,

            'tax_amount' => round($taxAmount, 2),

            'grand_total' => round($grandTotal, 2),
            'total_amount' => round($grandTotal, 2),
        ]);
    }
}