<?php
// app/Models/ProductHighlight.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHighlight extends Model
{
    protected $fillable = ['product_id', 'title', 'description', 'icon', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}