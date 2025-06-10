<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->domainWord(),
            'image' => $this->faker->imageUrl(),
            'slug' => $this->faker->slug,
            'status' => Category::STATUS['active'],
            'category_types' => 'PRODUCT',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
