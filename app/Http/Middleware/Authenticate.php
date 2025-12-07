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

        if ($request->is('admin/*')) {
            // Filament admin login route
            return route('filament.admin.auth.login');
        }

        if ($request->is('customer/*')) {
            // Customer area login
            return route('customer.login');
        }

        // Fallback: customer login for other areas
        return route('customer.login');
    }
}