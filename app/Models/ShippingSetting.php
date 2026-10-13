<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $table = 'shipping_settings';

    protected $fillable = [
        'shipping_type',
        'free_delivery_threshold',

        'min_weight',
        'weight_step',
        'weight_local_charge',
        'weight_local_extra',
        'weight_state_charge',
        'weight_state_extra',
        'weight_inter_charge',
        'weight_inter_extra',

        'min_pcs',
        'pcs_local_charge',
        'pcs_local_extra',
        'pcs_state_charge',
        'pcs_state_extra',
        'pcs_inter_charge',
        'pcs_inter_extra',
    ];

    protected $casts = [
        'free_delivery_threshold' => 'decimal:2',
        'min_weight'              => 'integer',
        'weight_step'             => 'integer',
        'min_pcs'                 => 'integer',
    ];

    public const TYPE_ORDER_VALUE = 'order_value';
    public const TYPE_WEIGHT      = 'weight';
    public const TYPE_PCS         = 'pcs';

    /**
     * Single-row settings: always returns the one record (creates it if missing).
     */
    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}