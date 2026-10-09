<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HomeContent
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    // "shop?category=toys" -> full url, full urls / # / / paths are kept as they are
    public static function resolveUrl(?string $link): string
    {
        if (blank($link)) {
            return '#';
        }

        return Str::startsWith($link, ['http://', 'https://', '/', '#', 'mailto:', 'tel:'])
            ? $link
            : url($link);
    }
}