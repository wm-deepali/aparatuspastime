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
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_system' => 'boolean',
    ];

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