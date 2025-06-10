<?php

namespace Database\Seeders;

use App\Enums\BannerPositionEnum;
use App\Enums\BannerTypeEnum;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::factory()->create([
            'banner_name' => 'Hero Banner (large)',
            'slug' => 'hero-banner-large',
            'width' => 680,
            'height' => 280,
            'image' => 'https://fakeimg.pl/680x280',
            'position' => BannerPositionEnum::TOP,
            'type' => BannerTypeEnum::FIXED,
            'status' => true,
            'title' => 'Huge Offer!!',
            'short_description' => 'Don\'nt miss out on this huge offer!!',
        ]);

        Banner::factory()->create([
            'banner_name' => 'Hero Banner (small) - 1',
            'slug' => 'hero-banner-small-1',
            'width' => 330,
            'height' => 170,
            'image' => 'https://fakeimg.pl/330x170',
            'position' => BannerPositionEnum::TOP,
            'type' => BannerTypeEnum::FIXED,
            'status' => true,
            'title' => 'Huge Offer!!',
            'short_description' => 'Don\'nt miss out on this huge offer!!',
        ]);

        Banner::factory()->create([
            'banner_name' => 'Hero Banner (small) - 2',
            'slug' => 'hero-banner-small-2',
            'width' => 330,
            'height' => 170,
            'image' => 'https://fakeimg.pl/330x170',
            'position' => BannerPositionEnum::TOP,
            'type' => BannerTypeEnum::FIXED,
            'status' => true,
            'title' => 'Huge Offer!!',
            'short_description' => 'Don\'nt miss out on this huge offer!!',
        ]);

        Banner::factory()->create([
            'banner_name' => 'Sidebar Banner 1',
            'slug' => 'sidebar-banner-1',
            'width' => 330,
            'height' => 660,
            'image' => 'https://fakeimg.pl/330x660',
            'position' => BannerPositionEnum::TOP,
            'type' => BannerTypeEnum::FIXED,
            'status' => true,
            'title' => 'Huge Offer!!',
            'short_description' => 'Don\'nt miss out on this huge offer!!',
        ]);

        Banner::factory()->create([
            'banner_name' => 'Sidebar Banner 2',
            'slug' => 'sidebar-banner-2',
            'width' => 330,
            'height' => 660,
            'image' => 'https://fakeimg.pl/330x660',
            'position' => BannerPositionEnum::TOP,
            'type' => BannerTypeEnum::FIXED,
            'status' => true,
            'title' => 'Huge Offer!!',
            'short_description' => 'Don\'nt miss out on this huge offer!!',
        ]);

        Banner::factory()->create([
            'banner_name' => 'Sidebar Banner 3',
            'slug' => 'sidebar-banner-3',
            'width' => 330,
            'height' => 660,
            'image' => 'https://fakeimg.pl/330x660',
            'position' => BannerPositionEnum::TOP,
            'type' => BannerTypeEnum::FIXED,
            'status' => true,
            'title' => 'Huge Offer!!',
            'short_description' => 'Don\'nt miss out on this huge offer!!',
        ]);
    }
}
