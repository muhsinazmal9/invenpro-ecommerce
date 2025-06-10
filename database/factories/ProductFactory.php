<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubsubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $subcategory = $category->subcategories()->inRandomOrder()->first();
        $subsubCategory = $subcategory->subsubCategories()->inRandomOrder()->first();

        return [
            'title' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'thumbnail' => $this->faker->imageUrl(),
            'short_description' => $this->faker->sentence,
            'long_description' => $this->faker->paragraph,
            'sku' => $this->faker->unique()->randomNumber(6),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'discount' => $this->faker->randomFloat(2, 1, 100),
            'discount_type' => $this->faker->randomElement(['fixed', 'percentage']),
            'stock' => $this->faker->numberBetween(0, 500),
            'seo_title' => $this->faker->sentence,
            'keywords' => $this->faker->words(5, true),
            'seo_description' => $this->faker->paragraph,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'subsub_category_id' => $subsubCategory->id,
            'brand_id' => $this->faker->numberBetween(1, 10),
            'featured' => $this->faker->randomElement([Product::FEATURED['active'], Product::FEATURED['inactive']]),
            'status' => $this->faker->randomElement([Product::STATUS['published'], Product::STATUS['draft']]),
            'tax_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
