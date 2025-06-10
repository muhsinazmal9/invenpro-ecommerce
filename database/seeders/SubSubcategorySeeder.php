<?php

namespace Database\Seeders;

use App\Models\SubsubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SubsubCategory::truncate();
        SubsubCategory::factory(10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
