<?php
// app/Models/ProductBenefit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBenefit extends Model
{
    protected $fillable = ['product_id', 'title', 'icon', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}