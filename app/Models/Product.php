<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'category_id',
        'subcategory_id',

        'name',
        'slug',

        'sku',
        'product_code',
        'hsn_code',

        'short_description',
        'description',
        'how_to_use',
        'delivery_returns',

        'mrp',
        'discount_type',
        'discount',
        'price',

        'stock',
        'min_qty',

        'delivery_time',
        'delivery_charge',

        // Age group (age_max NULL = no upper limit, e.g. "3+")
        'age_min',
        'age_max',

        'sort_order',
        'is_non_toxic',

        // Rating cache (updated when a review is approved)
        'rating_avg',
        'reviews_count',

        'meta_title',
        'meta_description',

        'status',

    ];

    protected $casts = [

        'status' => 'boolean',
        'is_featured' => 'boolean',
        'is_new_arrival' => 'boolean',

        'age_min' => 'integer',
        'age_max' => 'integer',
        'rating_avg' => 'float',
        'reviews_count' => 'integer',
        'is_non_toxic' => 'boolean',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    /**
     * ✅ Used across all grid/listing views (homepage sections, product
     * listing pages, etc). Prefers the compressed THUMB (400px) since
     * these are always shown small — falls back to the full image for
     * older rows created before the thumb column existed.
     */
    public function getDisplayImageAttribute()
    {
        $default = $this->images()
            ->where('is_default', 1)
            ->first();

        if ($default) {
            return asset('storage/' . ($default->thumb ?? $default->image));
        }

        $image = $this->images()->first();

        return $image
            ? asset('storage/' . ($image->thumb ?? $image->image))
            : null;
    }

    /**
     * "3+" or "3–5" — built from age_min / age_max. Null if no age is set.
     */
    public function getAgeLabelAttribute(): ?string
    {
        if (is_null($this->age_min)) {
            return null;
        }

        if (is_null($this->age_max)) {
            return $this->age_min . '+';
        }

        return $this->age_max === $this->age_min
            ? (string) $this->age_min
            : $this->age_min . '–' . $this->age_max;
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // "What's in the box" checklist
    public function includedItems()
    {
        return $this->hasMany(ProductIncludedItem::class)->orderBy('sort_order');
    }

    // "Developmental Benefits" chips
    public function benefits()
    {
        return $this->hasMany(ProductBenefit::class)->orderBy('sort_order');
    }

    // Overview highlight cards
    public function highlights()
    {
        return $this->hasMany(ProductHighlight::class)->orderBy('sort_order');
    }

    // ✅ product videos (Media → Video)
    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    // ✅ addon options (Addon Options section)
    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }

    // Collections — also drive the product badge (badge_text / badge_color)
    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'collection_product',
            'product_id',
            'collection_id'
        );
    }

    public function cartItems()
    {
        return $this->hasMany(
            CartItem::class
        );
    }

    public function scopeVisible($query)
    {
        $query->where('status', 1);

        if (StockSetting::current()->auto_disable_out_of_stock) {
            $query->where('stock', '>', 0);
        }

        return $query;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

}