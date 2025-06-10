<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaxSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tax_settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tax_settings')->insert([
            [
                'code' => 'GST',
                'slug' => 'gst',
                'rate' => 10,
                'created_at' => now(),
            ],
            [
                'code' => 'VAT',
                'slug' => 'vat',
                'rate' => 5,
                'created_at' => now(),
            ],
            [
                'code' => 'PST',
                'slug' => 'pst',
                'rate' => 8,
                'created_at' => now(),
            ],
        ]);
    }
}
