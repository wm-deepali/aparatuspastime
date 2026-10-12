<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutBelief extends Model
{
    protected $guarded = [];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }
}