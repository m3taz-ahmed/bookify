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
            
            // COMPREHENSIVE DEBUG LOGGING
            $debugFile = __DIR__ . '/../public/bootstrap-redirect-debug.log';
            $debug = "\n=== BOOTSTRAP REDIRECT DEBUG ===\n";
            $debug .= date('Y-m-d H:i:s') . "\n";
            $debug .= "Request path: " . $request->path() . "\n";
            $debug .= "ADMIN_ROUTE_OVERRIDE constant: " . (defined('ADMIN_ROUTE_OVERRIDE') ? 'YES' : 'NO') . "\n";
            $debug .= "getenv('IS_ADMIN_ROUTE'): " . (getenv('IS_ADMIN_ROUTE') ?: 'NULL') . "\n";
            $debug .= "\$_ENV['IS_ADMIN_ROUTE']: " . ($_ENV['IS_ADMIN_ROUTE'] ?? 'NULL') . "\n";
            $debug .= "getenv('ADMIN_ROUTE_OVERRIDE'): " . (getenv('ADMIN_ROUTE_OVERRIDE') ?: 'NULL') . "\n";
            @file_put_contents($debugFile, $debug, FILE_APPEND);
            
            // CRITICAL: Check if this is an admin route using CONSTANT (most reliable)
            if (defined('ADMIN_ROUTE_OVERRIDE') && ADMIN_ROUTE_OVERRIDE === true) {
                $debug .= "DECISION: Returning NULL (ADMIN_ROUTE_OVERRIDE constant detected)\n";
                @file_put_contents($debugFile, $debug, FILE_APPEND);
                return null;
            }
            
            // Fallback: Check environment variables
            if (getenv('IS_ADMIN_ROUTE') === 'true' || ($_ENV['IS_ADMIN_ROUTE'] ?? '') === 'true') {
                $debug .= "DECISION: Returning NULL (IS_ADMIN_ROUTE env detected)\n";
                @file_put_contents($debugFile, $debug, FILE_APPEND);
                return null;
            }
            
            // Fallback: Check request path directly
            if ($request->is('admin') || 
                $request->is('admin/*') || 
                str_contains($request->path(), 'admin') ||
                str_contains($request->path(), 'filament')) {
                $debug .= "DECISION: Returning NULL (admin path detected directly)\n";
                @file_put_contents($debugFile, $debug, FILE_APPEND);
                return null;
            }
            
            $debug .= "DECISION: Redirecting to customer.login\n";
            @file_put_contents($debugFile, $debug, FILE_APPEND);
            return route('customer.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();