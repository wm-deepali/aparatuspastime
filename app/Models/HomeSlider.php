<?php

namespace App\Models;

use App\Models\Concerns\HomeContent;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    use HomeContent;

    protected $fillable = [
        'image', 'image_alt',
        'badge_text', 'badge_icon', 'badge_color',
        'title_line1', 'title_line2', 'highlight_color',
        'description',
        'btn1_text', 'btn1_link', 'btn2_text', 'btn2_link',
        'nav_label', 'sort_order', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function getBtn1UrlAttribute(): string
    {
        return static::resolveUrl($this->btn1_link);
    }

    public function getBtn2UrlAttribute(): string
    {
        return static::resolveUrl($this->btn2_link);
    }
}