<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $ids = Wishlist::current()->latest()->pluck('product_id');

        $products = Product::query()
            ->whereIn('id', $ids)
            ->with(['collections', 'images', 'category'])
            ->withAvg('approvedReviews', 'rating')
            ->get()
            ->sortBy(fn($p) => $ids->search($p->id))  // recently added first
            ->values();
            
        return view('user.wishlist', compact('products'));
    }

    public function clear()
    {
        Wishlist::current()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Wishlist cleared.',
            'wishlist_count' => 0,
        ]);
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $exists = Wishlist::current()->where('product_id', $product->id)->exists();

        if ($exists) {
            Wishlist::removeProduct($product);
            $wishlisted = false;
            $message = 'Removed from wishlist.';
        } else {
            Wishlist::addProduct($product);
            $wishlisted = true;
            $message = 'Added to wishlist.';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'wishlisted' => $wishlisted,
            'wishlist_count' => Wishlist::current()->count(),
        ]);
    }
}