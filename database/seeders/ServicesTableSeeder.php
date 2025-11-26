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
            'description_en' => 'Professional haircut service',
            'description_ar' => 'خدمة قصة شعر احترافية',
            'duration_minutes' => 30,
            'price' => 25.00,
            'is_active' => true,
        ]);

        Service::create([
            'name_en' => 'Beard Trim',
            'name_ar' => 'تقليم اللحية',
            'description_en' => 'Professional beard trimming service',
            'description_ar' => 'خدمة تقليم لحية احترافية',
            'duration_minutes' => 20,
            'price' => 15.00,
            'is_active' => true,
        ]);

        Service::create([
            'name_en' => 'Hair Coloring',
            'name_ar' => 'صبغة شعر',
            'description_en' => 'Professional hair coloring service',
            'description_ar' => 'خدمة صبغة شعر احترافية',
            'duration_minutes' => 60,
            'price' => 60.00,
            'is_active' => true,
        ]);
    }
}