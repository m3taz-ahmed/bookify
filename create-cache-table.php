<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Check if cache table exists in bookify schema
    if (!Schema::hasTable('cache')) {
        echo "Creating cache table...\n";
        
        // Create cache table
        DB::statement("
            CREATE TABLE cache (
                `key` VARCHAR(255) PRIMARY KEY,
                `value` MEDIUMTEXT,
                `expiration` INT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        echo "Cache table created successfully!\n";
    } else {
        echo "Cache table already exists\n";
    }
    
    // Also create cache_locks table
    if (!Schema::hasTable('cache_locks')) {
        echo "Creating cache_locks table...\n";
        
        // Create cache_locks table
        DB::statement("
            CREATE TABLE cache_locks (
                `key` VARCHAR(255) PRIMARY KEY,
                `owner` VARCHAR(255),
                `expiration` INT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        
        echo "Cache_locks table created successfully!\n";
    } else {
        echo "Cache_locks table already exists\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}