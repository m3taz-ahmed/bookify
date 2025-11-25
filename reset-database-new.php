<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Get all tables in the current database
    $tables = DB::select("SHOW TABLES");
    
    echo "Found " . count($tables) . " tables in current database\n";
    
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // Drop each table
    foreach ($tables as $table) {
        // Get the table name
        $tableName = reset((array)$table);
        echo "Dropping table: $tableName\n";
        DB::statement("DROP TABLE IF EXISTS `$tableName`");
    }
    
    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    
    echo "All tables dropped successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}