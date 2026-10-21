<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['order_id','method','reference_number','screenshot','payment_date','remarks','recorded_by'];
    protected $casts = ['payment_date' => 'date'];

    public const METHODS = [
        'cash'         => 'Cash',
        'net_banking'  => 'Net Banking',
        'upi'          => 'UPI',
        'payment_link' => 'Payment Link',
    ];

    public function getMethodLabelAttribute(): string
    {
        return self::METHODS[$this->method] ?? ucfirst($this->method);
    }
}
