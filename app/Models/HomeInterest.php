<?php

namespace App\Models;

use App\Models\Concerns\HomeContent;
use Illuminate\Database\Eloquent\Model;

class HomeInterest extends Model
{
    use HomeContent;

    protected $fillable = [
        'icon', 'title', 'subtitle', 'color',
        'category_id', 'custom_link', 'sort_order', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Used by the storefront card
    public function getLinkUrlAttribute(): string
    {
        return $this->category
            ? url('shop') . '?category=' . $this->category->slug
            : static::resolveUrl($this->custom_link);
    }

    // Used by the admin list
    public function getLinkLabelAttribute(): string
    {
        return $this->category
            ? 'Category: ' . $this->category->name
            : ($this->custom_link ?: '—');
    }
}