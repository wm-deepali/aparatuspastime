<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    protected $fillable = [
        'customer_id',
        'user_type',
        'email',
        'event',
        'status',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'city',
        'country',
        'isp',
        'error_message',
        'meta',
        'logged_out_at',
        'duration_seconds',
    ];

    protected $casts = [
        'meta'          => 'array',
        'logged_out_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeCustomers($query)
    {
        return $query->where('user_type', 'customer');
    }
}