<?php

namespace App\Models;

use App\Models\Concerns\HomeContent;
use Illuminate\Database\Eloquent\Model;

class HomeUsp extends Model
{
    use HomeContent;

    protected $fillable = ['icon', 'title', 'subtitle', 'color', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];
}