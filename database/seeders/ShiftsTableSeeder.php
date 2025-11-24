<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Employee One shifts (user_id = 2)
        Shift::create([
            'user_id' => 2,
            'day_of_week' => 1, // Monday
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        Shift::create([
            'user_id' => 2,
            'day_of_week' => 2, // Tuesday
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        Shift::create([
            'user_id' => 2,
            'day_of_week' => 3, // Wednesday
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        Shift::create([
            'user_id' => 2,
            'day_of_week' => 4, // Thursday
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        Shift::create([
            'user_id' => 2,
            'day_of_week' => 5, // Friday
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
        ]);

        // Employee Two shifts (user_id = 3)
        Shift::create([
            'user_id' => 3,
            'day_of_week' => 1, // Monday
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
        ]);

        Shift::create([
            'user_id' => 3,
            'day_of_week' => 2, // Tuesday
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
        ]);

        Shift::create([
            'user_id' => 3,
            'day_of_week' => 3, // Wednesday
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
        ]);

        Shift::create([
            'user_id' => 3,
            'day_of_week' => 4, // Thursday
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
        ]);

        Shift::create([
            'user_id' => 3,
            'day_of_week' => 5, // Friday
            'start_time' => '12:00:00',
            'end_time' => '20:00:00',
        ]);

        Shift::create([
            'user_id' => 3,
            'day_of_week' => 6, // Saturday
            'start_time' => '10:00:00',
            'end_time' => '18:00:00',
        ]);

        Shift::create([
            'user_id' => 3,
            'day_of_week' => 0, // Sunday
            'start_time' => '10:00:00',
            'end_time' => '18:00:00',
        ]);
    }
}