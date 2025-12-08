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

        // Don't handle admin routes - Filament has its own auth middleware
        if ($request->is('admin*') || $request->is('*admin*') || $request->is('filament*')) {
            return null;
        }

        // Customer area routes
        return route('customer.login');
    }
}