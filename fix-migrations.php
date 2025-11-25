<?php
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Insert migration records for existing tables
$migrations = [
    '0001_01_01_000000_create_users_table',
    '0001_01_01_000001_create_cache_table',
    '0001_01_01_000002_create_jobs_table',
    '2025_11_24_135222_create_services_table',
    '2025_11_24_135316_create_shifts_table',
    '2025_11_24_135344_create_bookings_table',
    '2025_11_24_172529_add_checked_in_at_to_bookings_table',
    '2025_11_24_181454_create_sessions_table',
    '2025_11_24_182240_create_permission_tables',
    '2025_11_24_183003_remove_role_id_from_users_table',
    '2025_11_24_203435_add_sort_order_to_services_table',
    '2025_11_24_212500_create_activity_log_table',
    '2025_11_24_212501_add_event_column_to_activity_log_table',
    '2025_11_24_212502_add_batch_uuid_column_to_activity_log_table',
    '2025_11_24_213256_create_personal_access_tokens_table',
    '2025_11_24_221652_create_employee_service_durations_table',
    '2025_11_24_223544_create_customers_table',
    '2025_11_24_224115_add_customer_id_to_bookings_table',
    '2025_11_24_224934_create_customer_password_reset_tokens_table'
];

try {
    // Check if migrations table exists
    if (Schema::hasTable('migrations')) {
        echo "Migrations table exists\n";
        
        // Insert migration records
        foreach ($migrations as $migration) {
            // Check if migration already exists
            $exists = DB::table('migrations')->where('migration', $migration)->exists();
            
            if (!$exists) {
                DB::table('migrations')->insert([
                    'migration' => $migration,
                    'batch' => 1
                ]);
                echo "Inserted: $migration\n";
            } else {
                echo "Already exists: $migration\n";
            }
        }
        
        echo "Migration records inserted successfully!\n";
    } else {
        echo "Migrations table does not exist\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}