<?php

namespace App\Providers;

use App\Models\AgeGroup;
use App\Models\Collection;
use App\Models\DynamicPage;
use App\Models\Setting;
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
                    fn($ids) => app()->instance('wishlist.ids', $ids)
                );

            $view->with('wishlistCount', count($wishIds));
            $view->with('navAgeGroups', AgeGroup::active()->ordered()->get());
            $view->with('headerCollections', Collection::forHeader()->get());
            $view->with('footerPages', DynamicPage::where('status', 1)->orderBy('heading')->get(['heading', 'slug']));

            if (!isset($view->getData()['popularSearches'])) {
                $view->with('popularSearches', Setting::first()?->popular_search_list ?? []);
            }

        });

        View::composer('*', function ($view) {
            $view->with(['general' => \App\Models\Setting::first()]);
        });
    }
}