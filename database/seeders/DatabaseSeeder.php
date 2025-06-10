<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('optimize:clear');

        $this->call([
            SettingsSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            // CategorySeeder::class,
            // SubcategorySeeder::class,
            // SubSubcategorySeeder::class,
            CategoryHierarchySeeder::class,
            ProductSeeder::class,
            BrandSeeder::class,
            BannerSeeder::class,
            DeliveryScheduleSeeder::class,
        ]);
    }
}
