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
            $request = request();
            
            // DEBUG LOGGING - Remove after fixing
            \Log::info('=== REDIRECT GUESTS DEBUG ===');
            \Log::info('Full URL: ' . $request->url());
            \Log::info('Path: ' . $request->path());
            \Log::info('Request URI: ' . $request->getRequestUri());
            \Log::info('is(admin): ' . ($request->is('admin') ? 'YES' : 'NO'));
            \Log::info('is(admin/*): ' . ($request->is('admin/*') ? 'YES' : 'NO'));
            \Log::info('is(*admin*): ' . ($request->is('*admin*') ? 'YES' : 'NO'));
            \Log::info('is(filament*): ' . ($request->is('filament*') ? 'YES' : 'NO'));
            \Log::info('url contains /admin: ' . (str_contains($request->url(), '/admin') ? 'YES' : 'NO'));
            \Log::info('url contains /filament: ' . (str_contains($request->url(), '/filament') ? 'YES' : 'NO'));
            \Log::info('path contains admin: ' . (str_contains($request->path(), 'admin') ? 'YES' : 'NO'));
            \Log::info('path contains filament: ' . (str_contains($request->path(), 'filament') ? 'YES' : 'NO'));
            
            // Don't redirect admin routes - let Filament handle it
            // Check multiple patterns to handle various URL structures (e.g. /public/admin, /bookify/admin)
            if ($request->is('admin') || 
                $request->is('admin/*') || 
                $request->is('*admin*') ||
                $request->is('filament*') ||
                str_contains($request->url(), '/admin') ||
                str_contains($request->url(), '/filament') ||
                str_contains($request->path(), 'admin') ||
                str_contains($request->path(), 'filament')) {
                \Log::info('DECISION: Returning NULL - Let Filament handle it');
                \Log::info('=== END DEBUG ===');
                return null;
            }
            
            \Log::info('DECISION: Redirecting to customer.login');
            \Log::info('=== END DEBUG ===');
            return route('customer.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();