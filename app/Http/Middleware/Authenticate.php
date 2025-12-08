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
        if ($request->expectsJson()) {
            return null; 
        }

        // Don't redirect admin routes - let Filament handle it
        if ($request->is('admin') || 
            $request->is('admin/*') || 
            str_contains($request->path(), 'admin') ||
            str_contains($request->path(), 'filament')) {
            return null;
        }

        // Customer area routes
        return route('customer.login');
    }
}
