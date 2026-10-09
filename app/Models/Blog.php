<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'key_takeaways' => 'array',
        'tags' => 'array',
        'recommended_product_ids' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'show_home' => 'boolean',
        'status' => 'boolean',
    ];

    public function scopePublished($q)
    {
        return $q->where('status', 1)
            ->where(fn($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    /* ── Image helpers ── */
    protected static function resolveImage(?string $p): ?string
    {
        if (blank($p)) return null;
        if (Str::startsWith($p, ['http://', 'https://'])) return $p;
        if (Str::startsWith($p, ['assets/', 'images/'])) return asset($p);
        return asset('storage/' . $p);
    }

    public function getImageUrlAttribute(): ?string
    {
        return self::resolveImage($this->image) ?? self::resolveImage($this->banner_image);
    }

    public function getBannerUrlAttribute(): ?string
    {
        return self::resolveImage($this->banner_image) ?? self::resolveImage($this->image);
    }

    public function getAuthorAvatarUrlAttribute(): ?string
    {
        return self::resolveImage($this->author_avatar);
    }

    /* ── Display helpers (null = hide in view) ── */
    public function getDateLabelAttribute(): ?string
    {
        return $this->published_at?->format('F j, Y');
    }

    public function getReadTimeLabelAttribute(): string
    {
        $min = $this->read_time
            ?: max(1, (int) ceil(str_word_count(strip_tags((string) $this->content)) / 200));

        return $min . ' min read';
    }

    public function getViewsLabelAttribute(): ?string
    {
        $n = (int) $this->views_count;
        if ($n <= 0) return null;

        return ($n >= 1000 ? rtrim(rtrim(number_format($n / 1000, 1), '0'), '.') . 'k' : $n) . ' reads';
    }

    public function getAuthorInitialsAttribute(): string
    {
        $words = preg_split('/\s+/', trim(preg_replace('/[^\pL\s]/u', ' ', (string) $this->author_name)), -1, PREG_SPLIT_NO_EMPTY);

        return strtoupper(collect($words)->take(2)->map(fn($w) => Str::substr($w, 0, 1))->implode(''));
    }
}