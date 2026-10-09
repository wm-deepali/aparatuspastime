<?php

namespace App\Models;

use App\Models\Concerns\HomeContent;
use Illuminate\Database\Eloquent\Model;

class HomeFeature extends Model
{
    use HomeContent;

    protected $fillable = ['icon', 'title', 'description', 'color', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];
}