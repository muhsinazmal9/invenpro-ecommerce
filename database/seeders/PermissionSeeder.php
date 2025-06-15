<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $guard = 'web';

        $staticPermissions = [
            // Directly defined permissions not tied to constants
            'list_role',
            'create_role',
            'update_role',
            'delete_role',
            'list_faq',
            'create_faq',
            'update_faq',
            'delete_faq',
        ];

        $modelPermissions = [
            \App\Models\User::class => [
                'LIST', 'READ', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE', 'ASSIGN_ROLE',
            ],
            \App\Models\Category::class => ['LIST', 'READ', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\Subcategory::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\SubsubCategory::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\Brand::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\CmsPage::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\Banner::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\Promo::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\Tag::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\Product::class => [
                'LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE',
                'FEATURE_STATUS_UPDATE', 'NEW_ARRIVAL_STATUS_UPDATE',
            ],
            \App\Models\Order::class => ['LIST', 'STATUS_UPDATE', 'CANCEL_REQUEST_APPROVE'],
            \App\Models\DeliverySchedule::class => ['LIST', 'STATUS_UPDATE'],
            \App\Models\Transaction::class => ['LIST'],
            \App\Models\Campaign::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE', 'READ'],
            \App\Models\UserSearch::class => ['LIST', 'DELETE'],
            \App\Models\Deal::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
            \App\Models\FeatureHighlight::class => ['LIST', 'CREATE', 'UPDATE'],
            \App\Models\Attribute::class => ['LIST', 'CREATE', 'UPDATE', 'DELETE', 'STATUS_UPDATE'],
        ];

        $settingPermissions = [
            \App\Models\Settings::class => [
                'SITE_SETTINGS', 'BUSINESS_SETTINGS', 'LOGO_SETTINGS', 'STRIPE_SETTINGS',
                'SMTP_SETTINGS', 'CHARGES_SETTINGS', 'STOCK_SETTINGS', 'ORDER_SETTING',
                'COLOR_SETTING', 'AUTHENTICATION_SETTING',
            ],
            \App\Models\TaxSettings::class => ['TAX_SETTINGS'],
            \App\Models\SocialMedia::class => ['SOCIAL_MEDIA_SETTINGS'],
        ];

        $permissions = [];

        foreach ($staticPermissions as $perm) {
            $permissions[] = [
                'name' => $perm,
                'guard_name' => $guard,
                'created_at' => $now,
            ];
        }

        foreach ($modelPermissions as $model => $constants) {
            foreach ($constants as $const) {
                $permissions[] = [
                    'name' => constant("$model::$const"),
                    'guard_name' => $guard,
                    'created_at' => $now,
                ];
            }
        }

        foreach ($settingPermissions as $model => $constants) {
            foreach ($constants as $const) {
                $permissions[] = [
                    'name' => constant("$model::$const"),
                    'guard_name' => $guard,
                    'created_at' => $now,
                ];
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert($permissions);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
