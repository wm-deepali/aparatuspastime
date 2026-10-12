<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'customer' => \App\Http\Middleware\CustomerAuth::class,
            'maintenance.mode' => \App\Http\Middleware\MaintenanceModeMiddleware::class,
            'admin.timeout' => \App\Http\Middleware\AdminSessionTimeout::class,
        ]);

        // Where `guest` / `guest:customer` middleware sends already-logged-in users
        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->is('user/*') && Auth::guard('customer')->check()) {
                return route('user.dashboard');
            }

            return route('admin.dashboard');
        });

        $middleware->web(append: [
            \App\Http\Middleware\NoCacheHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();