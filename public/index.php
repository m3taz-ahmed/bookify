<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// DEBUG: Log every request
$logFile = __DIR__ . '/request-debug.log';
$logData = date('Y-m-d H:i:s') . " | " . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . " | " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
@file_put_contents($logFile, $logData, FILE_APPEND);

// CRITICAL FIX: Intercept admin routes and handle them specially
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$isAdminRoute = (
    $requestUri === '/admin' ||
    str_starts_with($requestUri, '/admin/') ||
    str_contains($requestUri, '/admin')
);

if ($isAdminRoute) {
    $debugLog = __DIR__ . '/admin-intercept.log';
    @file_put_contents($debugLog, date('Y-m-d H:i:s') . " | Admin route intercepted: " . $requestUri . "\n", FILE_APPEND);
    
    // Set flags
    define('ADMIN_ROUTE_OVERRIDE', true);
    $_ENV['IS_ADMIN_ROUTE'] = 'true';
    $_ENV['ADMIN_ROUTE_OVERRIDE'] = 'true';
    putenv('IS_ADMIN_ROUTE=true');
    putenv('ADMIN_ROUTE_OVERRIDE=true');
    
    // Load Laravel
    if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
        require $maintenance;
    }
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $request = Request::capture();
    
    // Check if this is NOT the login page
    if (!str_contains($requestUri, '/admin/login')) {
        @file_put_contents($debugLog, "  -> Not login page, checking for redirect...\n", FILE_APPEND);
        
        // Handle the request
        try {
            $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
            $response = $kernel->handle($request);
            
            // Check if response is a redirect to customer login
            if ($response->isRedirect()) {
                $redirectUrl = $response->headers->get('Location');
                @file_put_contents($debugLog, "  -> Redirect detected to: " . $redirectUrl . "\n", FILE_APPEND);
                
                if (str_contains($redirectUrl, '/customer/login')) {
                    @file_put_contents($debugLog, "  -> BLOCKING customer/login redirect, sending to admin/login instead\n", FILE_APPEND);
                    $kernel->terminate($request, $response);
                    header('Location: /admin/login');
                    exit;
                }
            }
            
            // Send the response and exit
            $kernel->terminate($request, $response);
            $response->send();
            exit;
            
        } catch (\Exception $e) {
            @file_put_contents($debugLog, "  -> Exception: " . $e->getMessage() . "\n", FILE_APPEND);
            // Continue to normal bootstrap below
        }
    } else {
        // This IS the login page, proceed normally
        @file_put_contents($debugLog, "  -> Login page, proceeding normally\n", FILE_APPEND);
        $app->handleRequest($request);
        exit;
    }
}

// Normal Laravel bootstrap for non-admin routes
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->handleRequest(Request::capture());
