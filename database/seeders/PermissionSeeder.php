<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\Deal;
use App\Models\DeliverySchedule;
use App\Models\FeatureHighlight;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Settings;
use App\Models\SocialMedia;
use App\Models\Subcategory;
use App\Models\SubsubCategory;
use App\Models\Tag;
use App\Models\TaxSettings;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserSearch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Role Management
            [
                'name' => 'list_role',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'create_role',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'update_role',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'delete_role',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // User Management
            [
                'name' => User::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => User::READ,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => User::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => User::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => User::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => User::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => User::ASSIGN_ROLE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Category Management
            [
                'name' => Category::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Category::READ,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Category::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Category::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Category::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Category::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Subcategory Management
            [
                'name' => Subcategory::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],

            [
                'name' => Subcategory::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Subcategory::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Subcategory::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Subcategory::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Sub Subcategory Management
            [
                'name' => SubsubCategory::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],

            [
                'name' => SubsubCategory::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => SubsubCategory::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => SubsubCategory::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => SubsubCategory::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Brand Management
            [
                'name' => Brand::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Brand::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Brand::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Brand::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Brand::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // CMS Page Management
            [
                'name' => CmsPage::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => CmsPage::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => CmsPage::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => CmsPage::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => CmsPage::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // FAQ Management
            [
                'name' => 'list_faq',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'create_faq',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'update_faq',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'delete_faq',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Banner Management
            [
                'name' => Banner::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Banner::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Banner::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Banner::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Banner::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Settings Management
            [
                'name' => Settings::SITE_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::BUSINESS_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::LOGO_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::STRIPE_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::SMTP_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::CHARGES_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => TaxSettings::TAX_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => SocialMedia::SOCIAL_MEDIA_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Promos
            [
                'name' => Promo::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Promo::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Promo::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ], [
                'name' => Promo::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ], [
                'name' => Promo::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ], [
                'name' => Tag::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Tag::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => TAG::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Tag::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Tag::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::FEATURE_STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Product::NEW_ARRIVAL_STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            // Order Management
            [
                'name' => Order::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Order::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Order::CANCEL_REQUEST_APPROVE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => DeliverySchedule::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Transaction::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::STOCK_SETTINGS,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Campaign::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Campaign::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Campaign::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Campaign::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Campaign::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Campaign::READ,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => UserSearch::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => UserSearch::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::ORDER_SETTING,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::COLOR_SETTING,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Settings::AUTHENTICATION_SETTING,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Deal::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Deal::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Deal::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Deal::DELETE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => Deal::STATUS_UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => FeatureHighlight::LIST,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => FeatureHighlight::CREATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => FeatureHighlight::UPDATE,
                'guard_name' => 'web',
                'created_at' => now(),
            ],

        ];

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        $permissionTable = DB::table('permissions');
        $permissionTable->truncate();
        $permissionTable->insert($permissions);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
