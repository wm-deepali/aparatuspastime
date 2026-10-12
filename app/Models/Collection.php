<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'code',
        'status',
        'is_system',
        'sort_order',
        'show_in_header',
        'header_order',
        'header_icon',
        'header_color',
        'header_badge',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_system' => 'boolean',
        'show_in_header' => 'boolean',
    ];

    public function scopeForHeader($query)
    {
        return $query->where('status', 1)
            ->where('show_in_header', 1)
            ->orderBy('header_order')
            ->orderBy('id');
    }

    protected static function booted(): void
    {
        static::deleting(function (Collection $collection) {
            if ($collection->is_system) {
                throw new \RuntimeException('System collections cannot be deleted.');
            }
        });
    }
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'collection_product',
            'collection_id',
            'product_id'
        );
    }
}