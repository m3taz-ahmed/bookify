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

        // Check if this is an admin/filament route
        // Admin routes should NOT redirect to customer login
        \Log::info('Checking admin routes...');
        \Log::info('is(admin): ' . ($request->is('admin') ? 'YES' : 'NO'));
        \Log::info('is(admin/*): ' . ($request->is('admin/*') ? 'YES' : 'NO'));
        \Log::info('is(*admin*): ' . ($request->is('*admin*') ? 'YES' : 'NO'));
        \Log::info('url contains /admin: ' . (str_contains($request->url(), '/admin') ? 'YES' : 'NO'));
        \Log::info('path contains admin: ' . (str_contains($request->path(), 'admin') ? 'YES' : 'NO'));
        
        if ($request->is('admin') || 
            $request->is('admin/*') || 
            str_contains($request->path(), 'admin') ||
            str_contains($request->path(), 'filament')) {
            \Log::info('DECISION: Returning NULL (Admin route detected - let Filament handle it)');
            \Log::info('=== END AUTHENTICATE DEBUG ===');
            // Return null to let Filament's own auth handle it
            // Filament will show its own login page
            return null;
        }

        // Customer area routes
        \Log::info('DECISION: Redirecting to customer.login');
        \Log::info('=== END AUTHENTICATE DEBUG ===');
        return route('customer.login');
    }
}