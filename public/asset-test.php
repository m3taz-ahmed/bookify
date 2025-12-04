<?php

require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test asset helper
echo "Asset URL test:\n";
echo "CSS Asset: " . asset('build/assets/app-RVw5FiE1.css') . "\n";
echo "JS Asset: " . asset('build/assets/app-BjsdPRt6.js') . "\n";
echo "Base URL: " . url('/') . "\n";
echo "Public Path: " . public_path() . "\n";

// Check if files exist
$cssPath = public_path('build/assets/app-RVw5FiE1.css');
$jsPath = public_path('build/assets/app-BjsdPRt6.js');

echo "\nFile existence check:\n";
echo "CSS File exists: " . (file_exists($cssPath) ? 'Yes' : 'No') . "\n";
echo "JS File exists: " . (file_exists($jsPath) ? 'Yes' : 'No') . "\n";

if (file_exists($cssPath)) {
    echo "CSS File size: " . filesize($cssPath) . " bytes\n";
}

if (file_exists($jsPath)) {
    echo "JS File size: " . filesize($jsPath) . " bytes\n";
}