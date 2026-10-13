<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'link', 'status'];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('id');
    }
}