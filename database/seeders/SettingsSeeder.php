<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => Settings::SITE_TITLE,
                'value' => 'Curly Tech',
                'created_at' => now(),
            ],
            [
                'key' => Settings::FRONTEND_URL,
                'value' => 'http://localhost:3000',
                'created_at' => now(),
            ],
            [
                'key' => Settings::DEFAULT_PHONE_CODE,
                'value' => '+1',
                'created_at' => now(),
            ],
            [
                'key' => Settings::DEFAULT_LANGUAGE,
                'value' => 'en',
                'created_at' => now(),
            ],
            [
                'key' => Settings::DEFAULT_CURRENCY,
                'value' => 'USD',
                'created_at' => now(),
            ],
            [
                'key' => Settings::CURRENCY_SYMBOL,
                'value' => '$',
                'created_at' => now(),
            ],
            [
                'key' => Settings::TIMEZONE,
                'value' => 'UTC',
                'created_at' => now(),
            ],
            [
                'key' => Settings::PRIMARY_LOGO,
                'value' => $this->getValue(Settings::PRIMARY_LOGO),
                'created_at' => now(),
            ],
            [
                'key' => Settings::SECONDARY_LOGO,
                'value' => $this->getValue(Settings::SECONDARY_LOGO),
                'created_at' => now(),
            ],
            [
                'key' => Settings::FAVICON,
                'value' => $this->getValue(Settings::FAVICON),
                'created_at' => now(),
            ],
            [
                'key' => Settings::INVOICE_PREFIX,
                'value' => 'LS',
                'created_at' => now(),
            ],
            [
                'key' => Settings::DEFAULT_AVATAR,
                'value' => $this->getValue(Settings::DEFAULT_AVATAR),
                'created_at' => now(),
            ],
            [
                'key' => Settings::OTP_VALIDATION_TIME,
                'value' => 5,
                'created_at' => now(),
            ],
            [
                'key' => Settings::COUNTRY_ID,
                'value' => 18,
                'created_at' => now(),
            ],
            [
                'key' => Settings::STATE_ID,
                'value' => 348,
                'created_at' => now(),
            ],
            [
                'key' => Settings::CITY_ID,
                'value' => 7291,
                'created_at' => now(),
            ],
            [
                'key' => Settings::SHIPPING_CHARGE,
                'value' => 0,
                'created_at' => now(),
            ],
            [
                'key' => Settings::GIFT_WRAPPING_CHARGE,
                'value' => 0,
                'created_at' => now(),
            ],
            [
                'key' => Settings::LOW_STOCK,
                'value' => 10,
                'created_at' => now(),
            ],
            [
                'key' => Settings::SERVICE_CHARGE,
                'value' => 0,
                'created_at' => now(),
            ],
            [
                'key' => Settings::GOOGLE_MAPS_API_KEY,
                'value' => '*****',
                'created_at' => now(),
            ],
            [
                'key' => Settings::BUSINESS_DESCRIPTION,
                'value' => 'LifeStyle is an ecommerce platform that offers a wide range of lifestyle products to its customers. From fashion, beauty, and home decor, to kitchenware, and personal care products, we have everything you need to enhance your lifestyle. Our platform is designed to provide a seamless and personalized shopping experience for our customers, making it easy to find and purchase the products that you love. Join us on our journey to create a lifestyle that you love.',
                'created_at' => now(),
            ],
            [
                'key' => Settings::EMAIL,
                'value' => 'life_style@gmail.com',
                'created_at' => now(),
            ],
            [
                'key' => Settings::PHONE_1,
                'value' => '0000000000',
                'created_at' => now(),
            ],
            [
                'key' => Settings::PHONE_2,
                'value' => '0000000000',
                'created_at' => now(),
            ],
            [
                'key' => Settings::PHONE_3,
                'value' => '0000000000',
                'created_at' => now(),
            ],
            [
                'key' => Settings::ADDRESS,
                'value' => '123 Fake Street, Fakeville, Fake Country',
                'created_at' => now(),
            ],
            [
                'key' => Settings::PAYPAL_STATUS,
                'value' => 1,
                'created_at' => now(),
            ],
            [
                'key' => Settings::STRIPE_STATUS,
                'value' => 1,
                'created_at' => now(),
            ],
            [
                'key' => Settings::RAZORPAY_STATUS,
                'value' => 1,
                'created_at' => now(),
            ],
            [
                'key' => Settings::PAYMENT_METHODS,
                'value' => '["paypal","stripe","razorpay"]',
                'created_at' => now(),
            ],
        ];

        $settingsTable = DB::table('settings');
        $settingsTable->truncate();
        $settingsTable->insert($settings);
    }

    protected function getValues(): array
    {
        return [
            Settings::PRIMARY_LOGO => getPlaceholderImage(184, 50),
            Settings::SECONDARY_LOGO => getPlaceholderImage(184, 50),
            Settings::FAVICON => getPlaceholderImage(64, 64),
            Settings::DEFAULT_AVATAR => getPlaceholderImage(150 , 150),
        ];
    }

    public function getValue($param)
    {
        return $this->getValues()[$param];
    }
}
