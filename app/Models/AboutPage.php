<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AboutPage extends Model
{
    protected $guarded = [];

    public function getStoryImageUrlAttribute(): ?string
    {
        if (!$this->story_image) {
            return null;
        }
        return Str::startsWith($this->story_image, ['http://', 'https://'])
            ? $this->story_image
            : asset($this->story_image);
    }
}