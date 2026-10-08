<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'sub_title',
        'description',      // new
        'meta_title',
        'meta_description',
        'image',
        'icon',             // new
        'pastel_bg',        // new
        'sort_order',

        'is_popular',
        'status',

        'added_by',
        'is_featured',
        'show_in_navbar',
        'is_sub_category',
    ];

    protected $casts = [
        'status'          => 'boolean',
        'is_popular'      => 'boolean',
        'is_featured'     => 'boolean',
        'show_in_navbar'  => 'boolean',
        'is_sub_category' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Parent
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Children (ignore soft deleted)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->whereNull('deleted_at');
    }

    public function categoryAttributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    // Products directly under category
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Products where this category is selected as subcategory
    public function subCategoryProducts()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Only active
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Only parent categories
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Only subcategories
    public function scopeSubCategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Default display order
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getIsParentAttribute()
    {
        return is_null($this->parent_id);
    }

    public function getIsChildAttribute()
    {
        return !is_null($this->parent_id);
    }
}