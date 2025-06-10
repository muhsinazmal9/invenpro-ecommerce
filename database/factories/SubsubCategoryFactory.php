<?php

namespace Database\Factories;

use App\Models\SubsubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubSubcategory>
 */
class SubsubCategoryFactory extends Factory
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
            'subcategory_id' => $this->faker->numberBetween(1, 10),
            'slug' => $this->faker->slug,
            'status' => SubsubCategory::STATUS['active'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
