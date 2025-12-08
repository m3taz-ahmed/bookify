<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$requestUri = $_SERVER['REQUEST_URI'] ?? '';

// Admin route handling - prevent redirect to customer login
$isAdminRoute = (
    $requestUri === '/admin' ||
    str_starts_with($requestUri, '/admin/') ||
    str_contains($requestUri, '/admin')
);

if ($isAdminRoute) {
    define('ADMIN_ROUTE_OVERRIDE', true);
    
    if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
        require $maintenance;
    }
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $request = Request::capture();
    
    if (!str_contains($requestUri, '/admin/login')) {
        try {
            $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
            $response = $kernel->handle($request);
            
            if ($response->isRedirect()) {
                $redirectUrl = $response->headers->get('Location');
                if (str_contains($redirectUrl, '/customer/login')) {
                    $kernel->terminate($request, $response);
                    header('Location: /admin/login');
                    exit;
                }
            }
            
            $kernel->terminate($request, $response);
            $response->send();
            exit;
            
        } catch (\Exception $e) {
            // Continue to normal bootstrap
        }
    } else {
        $app->handleRequest($request);
        exit;
    }
}

// Normal Laravel bootstrap
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->handleRequest(Request::capture());
