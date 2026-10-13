<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingSlab extends Model
{
    protected $table = 'shipping_slabs';

    protected $fillable = [
        'min_order_value',
        'max_order_value',
        'local_charge',
        'state_charge',
        'inter_charge',
    ];

    protected $casts = [
        'min_order_value' => 'decimal:2',
        'max_order_value' => 'decimal:2',
        'local_charge'    => 'decimal:2',
        'state_charge'    => 'decimal:2',
        'inter_charge'    => 'decimal:2',
    ];

    /**
     * Slab that matches a given order value.
     */
    public function scopeForSubtotal($query, $subtotal)
    {
        return $query->where('min_order_value', '<=', $subtotal)
            ->where(function ($q) use ($subtotal) {
                $q->whereNull('max_order_value')
                  ->orWhere('max_order_value', '>=', $subtotal);
            })
            ->orderByDesc('min_order_value');
    }
}