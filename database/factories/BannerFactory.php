<?php

namespace Database\Factories;

use App\Enums\BannerTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'slug' => fake()->slug(),
            'link' => fake()->url(),
            'status' => fake()->boolean(),
            'image' => fake()->imageUrl(),
            'type' => BannerTypeEnum::FIXED,
        ];
    }
}
