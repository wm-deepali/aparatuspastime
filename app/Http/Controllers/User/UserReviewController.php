<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();

        $reviews = ProductReview::where('customer_id', $customer->id)
            ->with('product')
            ->latest()
            ->paginate(10);

        // Delivered items this customer hasn't reviewed yet
        $reviewedItemIds = ProductReview::where('customer_id', $customer->id)->pluck('order_item_id');

        $toReview = OrderItem::whereHas('order', fn($q) => $q
                ->where('customer_id', $customer->id)
                ->where('status', 'delivered'))
            ->whereNotIn('id', $reviewedItemIds)
            ->with(['product', 'order'])
            ->latest()
            ->take(10)
            ->get();

        return view('user.reviews', compact('customer', 'reviews', 'toReview'));
    }

    public function create(Request $request)
    {
        $customer = auth('customer')->user();

        $item = OrderItem::whereKey($request->query('item'))
            ->whereHas('order', fn($q) => $q
                ->where('customer_id', $customer->id)
                ->where('status', 'delivered'))
            ->with(['product', 'order'])
            ->firstOrFail();

        if (ProductReview::where('customer_id', $customer->id)->where('order_item_id', $item->id)->exists()) {
            return redirect()->route('user.reviews')->with('error', 'You have already reviewed this product.');
        }

        return view('user.review-create', compact('customer', 'item'));
    }

    public function store(Request $request)
    {
        $customer = auth('customer')->user();

        $data = $request->validate([
            'order_item_id' => 'required|integer',
            'rating'        => 'required|integer|between:1,5',
            'title'         => 'nullable|string|max:120',
            'review'        => 'required|string|min:10|max:2000',
        ]);

        $item = OrderItem::whereKey($data['order_item_id'])
            ->whereHas('order', fn($q) => $q
                ->where('customer_id', $customer->id)
                ->where('status', 'delivered'))
            ->firstOrFail();

        if (ProductReview::where('customer_id', $customer->id)->where('order_item_id', $item->id)->exists()) {
            return redirect()->route('user.reviews')->with('error', 'You have already reviewed this product.');
        }

        ProductReview::create([
            'product_id'        => $item->product_id,
            'customer_id'       => $customer->id,
            'order_id'          => $item->order_id,
            'order_item_id'     => $item->id,
            'rating'            => $data['rating'],
            'title'             => $data['title'] ?? null,
            'review'            => $data['review'],
            'verified_purchase' => true,
            'featured'          => false,
            'status'            => 'pending',
        ]);

        return redirect()->route('user.reviews')
            ->with('success', 'Thanks! Your review was submitted and will appear once approved.');
    }

    public function destroy(ProductReview $review)
    {
        abort_unless($review->customer_id === auth('customer')->id(), 403);

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}