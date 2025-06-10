<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeatureHighlight;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeatureHighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FeatureHighlight::truncate();
        FeatureHighlight::factory(4)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
