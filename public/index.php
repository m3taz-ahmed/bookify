<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// DEBUG: Log every request to verify Laravel is being called
$logFile = __DIR__ . '/request-debug.log';
$logData = date('Y-m-d H:i:s') . " | " . ($_SERVER['REQUEST_METHOD'] ?? 'N/A') . " | " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
@file_put_contents($logFile, $logData, FILE_APPEND);

// CRITICAL FIX: Handle admin routes BEFORE Laravel boots
// This prevents any middleware from redirecting admin to customer login
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$isAdminRoute = (
    $requestUri === '/admin' ||
    str_starts_with($requestUri, '/admin/') ||
    str_contains($requestUri, '/admin') ||
    str_contains($requestUri, 'admin')
);

if ($isAdminRoute) {
    $debugLog = __DIR__ . '/admin-route-debug.log';
    $debugData = date('Y-m-d H:i:s') . " | Admin route detected: " . $requestUri . "\n";
    @file_put_contents($debugLog, $debugData, FILE_APPEND);
    
    // CRITICAL: Define constant BEFORE loading bootstrap/app.php
    // This way middleware can check it
    define('ADMIN_ROUTE_OVERRIDE', true);
    $_ENV['IS_ADMIN_ROUTE'] = 'true';
    $_ENV['ADMIN_ROUTE_OVERRIDE'] = 'true';
    putenv('IS_ADMIN_ROUTE=true');
    putenv('ADMIN_ROUTE_OVERRIDE=true');
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Additional logging after app is loaded
if (defined('ADMIN_ROUTE_OVERRIDE') && ADMIN_ROUTE_OVERRIDE === true) {
    $overrideLog = __DIR__ . '/admin-override.log';
    @file_put_contents($overrideLog, date('Y-m-d H:i:s') . " | ADMIN_ROUTE_OVERRIDE constant is defined\n", FILE_APPEND);
    
    $request = Request::capture();
    if ($request->is('admin') || $request->is('admin/*') || str_contains($request->path(), 'admin')) {
        @file_put_contents($overrideLog, "  -> Admin path confirmed: " . $request->path() . "\n", FILE_APPEND);
    }
}

$app->handleRequest(Request::capture());
