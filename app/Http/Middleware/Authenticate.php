<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // Log for debugging
        $logFile = public_path('auth-debug.log');
        $logData = date('Y-m-d H:i:s') . " | Path: " . $request->path() . " | Guards: " . implode(',', $guards) . "\n";
        @file_put_contents($logFile, $logData, FILE_APPEND);
        
        // Check if this is an admin/filament route
        if ($request->is('admin') || 
            $request->is('admin/*') || 
            str_contains($request->path(), 'admin') ||
            str_contains($request->path(), 'filament')) {
            
            @file_put_contents($logFile, "  -> Admin route detected, throwing exception\n", FILE_APPEND);
            // Let Filament handle authentication for admin routes
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectTo($request)
            );
        }
        
        @file_put_contents($logFile, "  -> Customer route, redirecting to customer.login\n", FILE_APPEND);
        // For customer routes, redirect to customer login
        throw new AuthenticationException(
            'Unauthenticated.', $guards, route('customer.login')
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null; 
        }

        // For admin routes, return null to let Filament handle it
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
