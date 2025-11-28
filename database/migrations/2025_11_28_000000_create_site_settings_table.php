<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key')->unique();
            $table->text('setting_value')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
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
                'setting_value' => json_encode([
                    'sunday' => ['start' => '09:00', 'end' => '17:00'],
                    'monday' => ['start' => '09:00', 'end' => '17:00'],
                    'tuesday' => ['start' => '09:00', 'end' => '17:00'],
                    'wednesday' => ['start' => '09:00', 'end' => '17:00'],
                    'thursday' => ['start' => '09:00', 'end' => '17:00'],
                    'friday' => null, // Closed
                    'saturday' => ['start' => '09:00', 'end' => '17:00'],
                ]),
                'description' => 'Working hours for each day of the week',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};