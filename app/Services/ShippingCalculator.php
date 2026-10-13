<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CustomerAddress;
use App\Models\InvoiceSetting;
use App\Models\ShippingSetting;
use App\Models\ShippingSlab;

class ShippingCalculator
{
    /**
     * @param float|null $payable  Raw items total minus coupon discount. Pass it from
     *                             recalculateTotals(); if omitted it is computed here.
     * @return array{charge: float, known: bool, free: bool, zone: ?string}
     * known = false when the zone can't be worked out yet (guest / no default address)
     */
    public static function forCart(Cart $cart, ?float $payable = null): array
    {
        $s = ShippingSetting::first();

        if (!$s) {
            return self::result(0, true);
        }

        // Same basis as the free-delivery progress bar: items total minus coupon discount.
        // Never use $cart->subtotal here, it has tax stripped out in inclusive mode.
        $payable ??= max(0, (float) $cart->items()->sum('total') - (float) $cart->discount);

        // Free delivery overrides every shipping type (and works for guests too)
        if ($s->free_delivery_threshold > 0 && $payable >= (float) $s->free_delivery_threshold) {
            return self::result(0, true, true);
        }

        $address = $cart->user_id
            ? CustomerAddress::where('customer_id', $cart->user_id)->where('is_default', 1)->first()
            : null;

        if (!$address) {
            return self::result(0, false);
        }

        $zone = self::zone($address);

        // load(), not loadMissing(): items may have just changed in this request
        $cart->load('items.product');

        $charge = match ($s->shipping_type) {
            ShippingSetting::TYPE_ORDER_VALUE => self::byOrderValue($payable, $zone),
            ShippingSetting::TYPE_WEIGHT      => self::byWeight($s, $cart, $zone),
            ShippingSetting::TYPE_PCS         => self::byPcs($s, $cart, $zone),
            default                           => 0,
        };

        return self::result($charge, true, false, $zone);
    }

    protected static function zone(CustomerAddress $address): string
    {
        $company = InvoiceSetting::first();

        if (!$company || !$company->company_state) {
            return 'state';
        }
        if ((int) $address->state_id !== (int) $company->company_state) {
            return 'inter';
        }
        return (int) $address->city_id === (int) $company->company_city ? 'local' : 'state';
    }

    protected static function byOrderValue(float $payable, string $zone): float
    {
        $slab = ShippingSlab::forSubtotal($payable)->first();

        return $slab ? (float) $slab->{$zone . '_charge'} : 0;
    }

    protected static function byWeight(ShippingSetting $s, Cart $cart, string $zone): float
    {
        $grams = $cart->items->sum(fn ($i) => (int) ($i->product->weight ?? 0) * $i->quantity);
        $extra = max(0, $grams - (int) $s->min_weight);
        $steps = $s->weight_step > 0 ? (int) ceil($extra / $s->weight_step) : 0;

        return (float) $s->{"weight_{$zone}_charge"} + $steps * (float) $s->{"weight_{$zone}_extra"};
    }

    protected static function byPcs(ShippingSetting $s, Cart $cart, string $zone): float
    {
        $pcs   = (int) $cart->items->sum('quantity');
        $extra = max(0, $pcs - (int) $s->min_pcs);

        return (float) $s->{"pcs_{$zone}_charge"} + $extra * (float) $s->{"pcs_{$zone}_extra"};
    }

    protected static function result(float $charge, bool $known, bool $free = false, ?string $zone = null): array
    {
        return ['charge' => round($charge, 2), 'known' => $known, 'free' => $free, 'zone' => $zone];
    }
}