<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function () {
            // Don't redirect admin routes - let Filament handle it
            if (request()->is('admin') || request()->is('admin/*')) {
                return null;
            }
            
            return route('customer.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();