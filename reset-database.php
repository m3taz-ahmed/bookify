<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Get all tables in the bookify database
    $tables = DB::select("SHOW TABLES LIKE 'bookify.%'");
    
    echo "Found " . count($tables) . " tables in bookify database\n";
    
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // Drop each table
    foreach ($tables as $table) {
        $tableName = $table->{'Tables_in_bookify'};
        echo "Dropping table: $tableName\n";
        Schema::dropIfExists($tableName);
    }
    
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    
    echo "All tables dropped successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}