<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'name_en' => 'Haircut',
            'name_ar' => 'قصة شعر',
            'description' => 'Professional haircut service',
            'duration_minutes' => 30,
            'price' => 25.00,
            'is_active' => true,
        ]);

        Service::create([
            'name_en' => 'Beard Trim',
            'name_ar' => 'تقليم اللحية',
            'description' => 'Professional beard trimming service',
            'duration_minutes' => 20,
            'price' => 15.00,
            'is_active' => true,
        ]);

        Service::create([
            'name_en' => 'Hair Coloring',
            'name_ar' => 'صبغة شعر',
            'description' => 'Professional hair coloring service',
            'duration_minutes' => 60,
            'price' => 60.00,
            'is_active' => true,
        ]);
    }
}