<?php

namespace App\Models;

use App\Traits\DefaultRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use DefaultRouteKey, HasFactory;

    public const SITE_SETTINGS = 'site_settings';

    public const GOOGLE_SETTINGS = 'google_settings';

    public const GOOGLE_MAPS_API_KEY = 'google_maps_api_key';

    public const EXTERNAL_API_KEYS = 'external_api_keys';

    public const BUSINESS_SETTINGS = 'business_settings';

    public const LOGO_SETTINGS = 'logo_settings';

    public const PAYMENT_GATEWAY_SETTINGS = 'payment_gateway_settings';

    public const EMAIL_TEMPLATE = 'email_template';

    public const STRIPE = 'stripe';

    public const STRIPE_SETTINGS = 'stripe_settings';

    public const STRIPE_PUBLISHABLE_KEY = 'stripe_publishable_key';

    public const STRIPE_SECRET_KEY = 'stripe_secret_key';

    public const STRIPE_STATUS = 'stripe_status';

    public const PAYPAL = 'paypal';

    public const PAYPAL_SETTINGS = 'paypal_settings';

    public const PAYPAL_STATUS = 'paypal_status';

    public const RAZORPAY = 'razorpay';

    public const RAZORPAY_SETTINGS = 'razorpay_settings';

    public const RAZORPAY_STATUS = 'razorpay_status';

    public const PAYMENT_METHODS = 'payment_methods';
    public const ACTIVE = 'active';

    public const INACTIVE = 'inactive';

    public const SMTP = 'smtp';

    public const SMTP_SETTINGS = 'smtp_settings';

    public const IMAGE_DIRECTORY = 'assets/img/uploads/settings/';

    public const SITE_TITLE = 'site_title';

    public const FRONTEND_URL = 'frontend_url';

    public const DEFAULT_PHONE_CODE = 'default_phone_code';

    public const DEFAULT_LANGUAGE = 'default_language';

    public const DEFAULT_CURRENCY = 'default_currency';

    public const CURRENCY_SYMBOL = 'currency_symbol';

    public const TIMEZONE = 'timezone';

    public const LOGO = 'logo';

    public const PRIMARY_LOGO = 'primary_logo';

    public const SECONDARY_LOGO = 'secondary_logo';

    public const FAVICON = 'favicon';

    public const DEFAULT_AVATAR = 'default_avatar';

    public const SMTP_HOST = 'smtp_host';

    public const SMTP_PORT = 'smtp_port';

    public const MAIL_USERNAME = 'smtp_username';

    public const SMTP_PASSWORD = 'smtp_password';

    public const SMTP_ENCRYPTION = 'smtp_encryption';

    public const SMTP_FROM_ADDRESS = 'smtp_from_address';

    public const SMTP_FROM_NAME = 'smtp_from_name';

    public const STOCK_SETTINGS = 'stock_settings';

    public const CREATED = 'created';

    public const UPDATED = 'updated';

    public const DELETED = 'deleted';

    public const RESTORED = 'restored';

    public const ORDER_CANCEL = 'order_cancel';

    public const PERMANENTLY_DELETED = 'permanently_deleted';

    public const LOW_STOCK = 'low_stock';

    public const ORDER_SETTING = 'order_settings';

    public const AUTHENTICATION_SETTING = 'authentication_settings';

    public const COLOR_SETTING = 'color_settings';

    public const INVOICE_PREFIX = 'invoice_prefix';

    public const REPORTS_LIST = 'list_reports';

    public const OTP_VALIDATION_TIME = 'otp_validation_time';

    public const COUNTRY_ID = 'country_id';

    public const STATE_ID = 'state_id';

    public const CITY_ID = 'city_id';

    public const CHARGES_SETTINGS = 'charges_settings';

    public const SHIPPING_CHARGE = 'shipping_charge';

    public const GIFT_WRAPPING_CHARGE = 'gift_wrapping_charge';

    public const SERVICE_CHARGE = 'service_charge';

    public const BUSINESS_DESCRIPTION  = 'business_description';

    public const EMAIL  = 'email';

    public const PHONE_1  = 'phone_1';

    public const PHONE_2  = 'phone_2';

    public const PHONE_3  = 'phone_3';

    public const ADDRESS  = 'address';


    protected $fillable = [
        'key',
        'value',
    ];
}
