<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if settings already exist
        if (DB::table('site_settings')->where('setting_key', 'max_capacity')->exists()) {
            return;
        }
        
        // Insert default site settings
        DB::table('site_settings')->insert([
            [
                'setting_key' => 'max_capacity',
                'setting_value' => '200',
                'description' => 'Maximum number of people allowed per day',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_key' => 'working_hours',
                'setting_value' => '{"sunday":[{"start":"09:00","end":"12:00"},{"start":"14:00","end":"17:00"}],"monday":[{"start":"09:00","end":"17:00"}],"tuesday":[{"start":"09:00","end":"17:00"}],"wednesday":[{"start":"09:00","end":"17:00"}],"thursday":[{"start":"09:00","end":"17:00"}],"friday":null,"saturday":[{"start":"09:00","end":"17:00"}]}
',
                'description' => 'Working hours for each day of the week (supports multiple time slots per day)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
