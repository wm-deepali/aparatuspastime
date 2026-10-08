<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        View::composer('layouts.app', function ($view) {
            $cart = auth('customer')->check()
                ? \App\Models\Cart::where('user_id', auth('customer')->id())->first()
                : \App\Models\Cart::where('session_id', session()->getId())->first();

            $view->with('cartCount', $cart ? (int) $cart->items()->sum('quantity') : 0);
        });
        View::composer('*', function ($view) {
            $general = \App\Models\Setting::first();

            $view->with(
                [
                    'general' => $general,
                ]
            );
        });



    }
}
