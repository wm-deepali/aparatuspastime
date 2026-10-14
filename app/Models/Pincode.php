<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = [
        'pincode',
        'state_id',
        'city_id',
        'district',
        'is_serviceable',
    ];

    protected $casts = [
        'is_serviceable' => 'boolean',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeServiceable($query)
    {
        return $query->where('is_serviceable', 1);
    }
}