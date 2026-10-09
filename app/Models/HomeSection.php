<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = [
        'section_key', 'badge_text', 'badge_icon',
        'title', 'title_highlight', 'subtitle',
        'button_text', 'button_link', 'extra', 'status',
    ];

    protected $casts = [
        'extra'  => 'array',
        'status' => 'boolean',
    ];

    /**
     * Storefront helper: HomeSection::content('categories')
     * Never returns null. If the admin hasn't opened that section yet,
     * you get the default text from config/home_content.php.
     */
    public static function content(string $key): self
    {
        $row = static::where('section_key', $key)->first();

        if ($row) {
            return $row;
        }

        return (new static)->forceFill(
            ['section_key' => $key, 'status' => true] + config("home_content.sections.$key.defaults", [])
        );
    }

    public function getButtonUrlAttribute(): string
    {
        $link = $this->button_link;

        if (blank($link)) {
            return '#';
        }

        return \Illuminate\Support\Str::startsWith($link, ['http://', 'https://', '/', '#'])
            ? $link
            : url($link);
    }
}