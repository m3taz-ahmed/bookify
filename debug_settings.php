<?php

use App\Models\SiteSetting;

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$setting = SiteSetting::where('setting_key', 'max_capacity')->first();

if ($setting) {
    echo "Found setting: max_capacity\n";
    echo "Raw setting_value from DB (simulated): " . json_encode($setting->getRawOriginal('setting_value')) . "\n";
    echo "Casted setting_value: " . json_encode($setting->setting_value) . "\n";
    echo "Type of casted value: " . gettype($setting->setting_value) . "\n";
} else {
    echo "Setting 'max_capacity' not found. Creating it...\n";
    SiteSetting::create([
        'setting_key' => 'max_capacity',
        'setting_value' => 200
    ]);
    echo "Created. Run again to check.\n";
}
