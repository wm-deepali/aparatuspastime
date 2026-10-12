<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    protected $fillable = [
        'slug',
        'badge_text',
        'heading',
        'date_label',
        'effective_date',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'is_system',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'status'         => 'boolean',
        'is_system'      => 'boolean',
    ];

    public const DATE_LABELS = ['Last Updated', 'Effective Date'];

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 1);
    }

    /**
     * Public URL: built-in pages live at /{slug} (their old URLs), custom pages at /page/{slug}
     */
    public function getUrlAttribute(): string
    {
        return $this->is_system ? url($this->slug) : url('page/' . $this->slug);
    }

    /**
     * "Last Updated: March 2026" (null when no date is set)
     */
    public function getDateLineAttribute(): ?string
    {
        if (!$this->effective_date) {
            return null;
        }

        return ($this->date_label ?: 'Last Updated') . ': ' . $this->effective_date->format('F Y');
    }
}