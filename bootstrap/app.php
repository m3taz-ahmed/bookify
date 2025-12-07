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
        // Either comment out the redirect completely for now:
        // $middleware->redirectGuestsTo(function () {
        //     return route('customer.login');
        // });

        // Or keep the admin exception version if you prefer:
        $middleware->redirectGuestsTo(function () {
            if (request()->is('admin*')) {
                return null; // let Filament handle it
            }

            return route('customer.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();