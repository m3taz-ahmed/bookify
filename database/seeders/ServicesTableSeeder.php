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
            'name_en' => 'Sky Bridge Tour',
            'name_ar' => 'جولة جسر السماء',
            'description_en' => 'Experience the breathtaking views from the Sky Bridge',
            'description_ar' => 'استمتع بالمناظر الخلابة من جسر السماء',
            'price' => 25.00,
            'is_active' => true,
        ]);

        Service::create([
            'name_en' => 'VIP Sky Bridge Tour',
            'name_ar' => 'جولة جسر السماء الخاصة',
            'description_en' => 'Premium VIP experience with priority access',
            'description_ar' => 'تجربة خاصة مع أولوية الوصول',
            'price' => 50.00,
            'is_active' => true,
        ]);

        Service::create([
            'name_en' => 'Sunset Sky Bridge Tour',
            'name_ar' => 'جولة غروب الشمس على جسر السماء',
            'description_en' => 'Enjoy the beautiful sunset views from the Sky Bridge',
            'description_ar' => 'استمتع بمناظر غروب الشمس الجميلة من جسر السماء',
            'price' => 35.00,
            'is_active' => true,
        ]);
    }
}