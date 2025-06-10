<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->domainWord(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'image' => $this->faker->imageUrl(),
            'slug' => $this->faker->slug,
            'status' => Subcategory::STATUS['active'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
