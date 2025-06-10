<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubsubCategory;
use Illuminate\Support\Facades\DB;

class CategoryHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        Subcategory::truncate();
        SubSubcategory::truncate();

        // Create 10 categories
        Category::factory(10)->create()->each(function ($category) {
            // For each category, create 3 subcategories
            Subcategory::factory(3)->create(['category_id' => $category->id])
                ->each(function ($subcategory) {
                    // For each subcategory, create 3 subsubcategories
                    SubsubCategory::factory(3)->create(['subcategory_id' => $subcategory->id]);
                });
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
