<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_en' => fake()->word(),
            'name_ar' => fake()->word(),
            'description_en' => fake()->sentence(),
            'description_ar' => fake()->sentence(),
            'duration_minutes' => fake()->randomElement([15, 30, 45, 60]),
            'price' => fake()->randomFloat(2, 10, 100),
            'is_active' => true,
        ];
    }
}