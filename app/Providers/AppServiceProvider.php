<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $cart = auth('customer')->check()
                ? \App\Models\Cart::where('user_id', auth('customer')->id())->first()
                : \App\Models\Cart::where('session_id', session()->getId())->first();

            $view->with('cartCount', $cart ? (int) $cart->items()->sum('quantity') : 0);

            // Wishlist ids are fetched once per request and shared with product-card
            $wishIds = app()->bound('wishlist.ids')
                ? app('wishlist.ids')
                : tap(
                    \App\Models\Wishlist::current()->pluck('product_id')->all(),
                    fn ($ids) => app()->instance('wishlist.ids', $ids)
                );

            $view->with('wishlistCount', count($wishIds));
        });

        View::composer('*', function ($view) {
            $view->with(['general' => \App\Models\Setting::first()]);
        });
    }
}