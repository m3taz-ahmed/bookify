<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // DEBUG LOGGING
        \Log::info('=== AUTHENTICATE MIDDLEWARE DEBUG ===');
        \Log::info('Full URL: ' . $request->url());
        \Log::info('Path: ' . $request->path());
        \Log::info('Expects JSON: ' . ($request->expectsJson() ? 'YES' : 'NO'));
        
        if ($request->expectsJson()) {
            \Log::info('DECISION: Returning NULL (JSON request)');
            \Log::info('=== END AUTHENTICATE DEBUG ===');
            return null; 
        }

        // Don't handle admin routes - Filament has its own auth middleware
        // Using str_contains to handle various URL structures (e.g. /public/admin, /bookify/admin)
        \Log::info('Checking admin routes...');
        \Log::info('is(admin): ' . ($request->is('admin') ? 'YES' : 'NO'));
        \Log::info('is(admin/*): ' . ($request->is('admin/*') ? 'YES' : 'NO'));
        \Log::info('is(*admin*): ' . ($request->is('*admin*') ? 'YES' : 'NO'));
        \Log::info('url contains /admin: ' . (str_contains($request->url(), '/admin') ? 'YES' : 'NO'));
        
        if ($request->is('admin') || 
            $request->is('admin/*') || 
            $request->is('*admin*') || 
            $request->is('filament*') ||
            str_contains($request->url(), '/admin') ||
            str_contains($request->url(), '/filament')) {
            \Log::info('DECISION: Returning NULL (Admin route detected)');
            \Log::info('=== END AUTHENTICATE DEBUG ===');
            return null;
        }

        // Customer area routes
        \Log::info('DECISION: Redirecting to customer.login');
        \Log::info('=== END AUTHENTICATE DEBUG ===');
        return route('customer.login');
    }
}