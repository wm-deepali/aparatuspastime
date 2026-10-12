<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $fillable = [
        'age_min',
        'age_max',
        'slug',
        'short_label',
        'label',
        'name',
        'description',
        'icon',
        'color',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'age_min'    => 'integer',
        'age_max'    => 'integer',
        'sort_order' => 'integer',
        'status'     => 'boolean',
    ];

    public const COLORS = ['blue', 'orange', 'purple', 'rose', 'mint', 'yellow'];

    protected static function booted(): void
    {
        // Slug and short label are always derived from the range, never typed by the admin
        static::saving(function (AgeGroup $g) {
            $g->slug = static::makeSlug($g->age_min, $g->age_max);

            if (blank($g->short_label)) {
                $g->short_label = static::makeRangeText($g->age_min, $g->age_max);
            }
            if (blank($g->label)) {
                $g->label = static::makeRangeText($g->age_min, $g->age_max) . ' Years';
            }
        });
    }

    /* ---------- helpers ---------- */

    // 3-5, 12+, 4 (when min == max)
    public static function makeSlug(int $min, ?int $max): string
    {
        if (is_null($max)) {
            return $min . '+';
        }

        return $max === $min ? (string) $min : $min . '-' . $max;
    }

    // 3–5, 12+, 4
    public static function makeRangeText(int $min, ?int $max): string
    {
        if (is_null($max)) {
            return $min . '+';
        }

        return $max === $min ? (string) $min : $min . '–' . $max;
    }

    /* ---------- scopes ---------- */

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 1);
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('age_min');
    }

    /* ---------- product matching ---------- */

    /**
     * Limit a Product query to products whose age range OVERLAPS this group.
     * e.g. a product for ages 4–7 matches both "3-5" and "6-8".
     * Products with no age_min set never match.
     */
    public function applyToProducts($productQuery)
    {
        return $productQuery->where(function ($q) {
            $q->whereNotNull('products.age_min');

            // product starts at or before this group ends (skip when group is open ended)
            if (!is_null($this->age_max)) {
                $q->where('products.age_min', '<=', $this->age_max);
            }

            // product has no upper limit, or ends at or after this group starts
            $q->where(function ($q2) {
                $q2->whereNull('products.age_max')
                   ->orWhere('products.age_max', '>=', $this->age_min);
            });
        });
    }
}