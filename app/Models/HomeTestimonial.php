<?php

namespace App\Models;

use App\Models\Concerns\HomeContent;
use Illuminate\Database\Eloquent\Model;

class HomeTestimonial extends Model
{
    use HomeContent;

    protected $fillable = [
        'customer_name', 'customer_title', 'review', 'rating',
        'product_tag', 'tag_icon', 'color', 'is_verified',
        'sort_order', 'status',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'is_verified' => 'boolean',
        'status'      => 'boolean',
    ];

    // "Pooja Sharma" -> "PS"
    public function getInitialsAttribute(): string
    {
        $words = array_filter(
            preg_split('/\s+/', trim($this->customer_name)),
            fn($w) => preg_match('/^[\pL]/u', $w)
        );

        return mb_strtoupper(
            collect($words)->take(2)->map(fn($w) => mb_substr($w, 0, 1))->implode('')
        );
    }
}