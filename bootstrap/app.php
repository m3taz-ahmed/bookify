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
            
            // DEBUG LOGGING using file_put_contents (more reliable than Log)
            $logFile = __DIR__ . '/../public/redirect-debug.log';
            $logData = "\n=== REDIRECT GUESTS DEBUG ===\n";
            $logData .= date('Y-m-d H:i:s') . "\n";
            $logData .= 'Full URL: ' . $request->url() . "\n";
            $logData .= 'Path: ' . $request->path() . "\n";
            $logData .= 'Request URI: ' . $request->getRequestUri() . "\n";
            $logData .= 'is(admin): ' . ($request->is('admin') ? 'YES' : 'NO') . "\n";
            $logData .= 'is(admin/*): ' . ($request->is('admin/*') ? 'YES' : 'NO') . "\n";
            $logData .= 'path contains admin: ' . (str_contains($request->path(), 'admin') ? 'YES' : 'NO') . "\n";
            
            // Check if this is an admin/filament route
            $isAdminRoute = $request->is('admin') || 
                           $request->is('admin/*') || 
                           str_contains($request->path(), 'admin') ||
                           str_contains($request->path(), 'filament');
            
            if ($isAdminRoute) {
                $logData .= 'DECISION: Returning NULL - Let Filament handle it' . "\n";
                $logData .= '=== END DEBUG ===' . "\n";
                @file_put_contents($logFile, $logData, FILE_APPEND);
                return null;
            }
            
            $logData .= 'DECISION: Redirecting to customer.login' . "\n";
            $logData .= '=== END DEBUG ===' . "\n";
            @file_put_contents($logFile, $logData, FILE_APPEND);
            return route('customer.login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();