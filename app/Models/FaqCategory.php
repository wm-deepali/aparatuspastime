<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $guarded = [];

    protected $casts = ['status' => 'boolean'];

    public function faqs()
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($q)
    {
        return $q->where('status', 1);
    }
}