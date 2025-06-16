<?php

use App\Models\Tag;
use App\Models\Deal;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Banner;
use App\Models\Address;
use App\Models\CmsPage;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\Settings;
use App\Models\Newsletter;
use App\Models\Subscriber;
use App\Models\UserSearch;
use App\Models\SocialMedia;
use App\Models\Subcategory;
use App\Models\TaxSettings;
use App\Models\SubsubCategory;
use App\Models\DeliverySchedule;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderMailController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TaxSettingsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\SubsubCategoryController;
use App\Http\Controllers\DeliveryScheduleController;
use App\Http\Controllers\FeatureHighlightController;

Route::name('admin.')->prefix('/admin')->middleware(['auth', 'verified'])->group(function () {
    Route::controller(DashboardController::class)->name('dashboard.')->prefix('/')->group(function () {
        Route::get('/', '__invoke')->name('index');
        Route::get('/get-top-products', 'getTopProduct')->name('get.top.products');
        Route::get('/get-product-reviews', 'getProductReview')->name('get.product.reviews');
        Route::get('/get-todays-transactions-list', 'getTodaysTransactionsList')->name('get.todays.transactions.list');
        Route::get('/get-user-activity-list', 'getUserActivity')->name('get.user.activity.list');
        Route::get('/get-all-users', 'getAllUsers')->name('get.all.users');
    });

    Route::controller(ProfileController::class)->prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

    Route::controller(RoleManagementController::class)
        ->name('role.')->prefix('/role')
        ->group(function () {
            Route::get('/create-permission', 'storePermission');
            Route::put('/role/assign/{user}/{role}', 'assignRole')->name('assign');
            Route::get('/getList', 'getList')->name('getList');

        });

    Route::controller(UserController::class)
        ->name('users.')->prefix('/users')
        ->group(function () {
            Route::get('/getList', 'getList')->name('getList');
            Route::patch('status/{user}', 'statusUpdate')->name('status.update')->middleware('can:'.User::STATUS_UPDATE);
        });

    Route::controller(CategoryController::class)
        ->prefix('/category')->name('category.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.Category::LIST);
            Route::patch('statusUpdate/{category}', 'statusUpdate')->name('statusUpdate')->middleware('can:'.Category::STATUS_UPDATE);
        });

    Route::controller(SubcategoryController::class)
        ->prefix('/subcategory')->name('subcategory.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.Subcategory::LIST);
            Route::patch('/statusUpdate/{subcategory}', 'statusUpdate')->name('statusUpdate')->middleware('can:'.Subcategory::STATUS_UPDATE);
        });
    Route::controller(SubsubcategoryController::class)
        ->prefix('/subsubcategory')->name('subsubcategory.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.SubsubCategory::LIST);
            Route::patch('/statusUpdate/{subsubcategory}', 'statusUpdate')->name('statusUpdate')->middleware('can:'.SubsubCategory::STATUS_UPDATE);
        });

    Route::controller(BrandController::class)
        ->prefix('/brand')->name('brand.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.Brand::LIST);
            Route::patch('statusUpdate/{brand}', 'statusUpdate')->name('status.update')->middleware('can:'.Brand::STATUS_UPDATE);
        });
    Route::controller(PromoController::class)
        ->prefix('/promo')->name('promo.')->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.Promo::LIST);
            Route::patch('/status/{promo}', 'status')->name('status')->middleware('can:'.Promo::STATUS_UPDATE);
        });

    Route::controller(SettingsController::class)->prefix('/settings')->name('settings.')->group(function () {
        // Site Settings
        Route::get('/site', 'siteSettings')->name('site')->middleware('can:'.Settings::SITE_SETTINGS);
        Route::patch('/site', 'UpdateSiteSettingsRequest')->name('site.update')->middleware('can:'.Settings::SITE_SETTINGS);

        // Business Settings
        Route::get('/business', 'businessSettings')->name('business')->middleware('can:'.Settings::BUSINESS_SETTINGS);
        Route::patch('/business', 'updateBusinessSettings')->name('business.update')->middleware('can:'.Settings::BUSINESS_SETTINGS);
        Route::get('get/country/{country_id}', 'getCountry')->name('get.country')->middleware('can:'.Settings::BUSINESS_SETTINGS);
        Route::get('get/states/{country_id}', 'getStates')->name('get.states')->middleware('can:'.Settings::BUSINESS_SETTINGS);
        Route::get('get/cities/{country_id}', 'getCities')->name('get.cities')->middleware('can:'.Settings::BUSINESS_SETTINGS);

        // Logo and Favicon Settings
        Route::get('/logo-and-favicon', 'logoSettings')->name('logo')->middleware('can:'.Settings::LOGO_SETTINGS);
        Route::patch('/logo-and-favicon', 'updateLogoSettings')->name('logo.update')->middleware('can:'.Settings::LOGO_SETTINGS);

        // SMTP Settings
        Route::get('/smtp', 'smtpSettings')->name('smtp')->middleware('can:'.Settings::SMTP_SETTINGS);
        Route::patch('/smtp', 'updateSmtpSettings')->name('smtp.update')->middleware('can:'.Settings::SMTP_SETTINGS);

        // Shipping charge settings
        Route::get('/charges', 'chargesSettings')->name('charges')->middleware('can:'.Settings::CHARGES_SETTINGS);
        Route::patch('/charges', 'updateChargesSettings')->name('charges.update')->middleware('can:'.Settings::CHARGES_SETTINGS);

        // Stock related settings
        Route::get('/stock', 'stockSettings')->name('stock')->middleware('can:'.Settings::STOCK_SETTINGS);
        Route::patch('/stock', 'updateStockSettings')->name('stock.update')->middleware('can:'.Settings::STOCK_SETTINGS);

        // Order related setting
        Route::get('/order', 'orderSettings')->name('order')->middleware('can:'.Settings::ORDER_SETTING);
        Route::patch('/order', 'updateOrderSettings')->name('order.update')->middleware('can:'.Settings::ORDER_SETTING);


        // Color related setting
        Route::get('/color', 'colorSettings')->name('color')->middleware('can:'.Settings::COLOR_SETTING);
        Route::patch('/color', 'updateColorSettings')->name('color.update')->middleware('can:'.Settings::COLOR_SETTING);

        // Authentication related setting
        Route::get('/authentication', 'authenticationSettings')->name('authentication')->middleware('can:'.Settings::AUTHENTICATION_SETTING);
        Route::patch('/authentication', 'updateAuthenticationSettings')->name('authentication.update')->middleware('can:'.Settings::AUTHENTICATION_SETTING);

        // Payment gateway settings
        Route::prefix('/payment-gateway')->name('payment-gateway.')->group(function () {
            Route::get('/stripe', 'stripeSettings')->name('stripe')->middleware('can:'.Settings::STRIPE_SETTINGS);
            Route::patch('/stripe', 'updateStripeSettings')->name('stripe.update')->middleware('can:'.Settings::STRIPE_SETTINGS);
            Route::get('/paypal', 'paypalSettings')->name('paypal')->middleware('can:'.Settings::PAYPAL_SETTINGS);
            Route::patch('/paypal', 'updatePaypalSettings')->name('paypal.update')->middleware('can:'.Settings::PAYPAL_SETTINGS);
        });

        // External API settings

        Route::get('/external-api', [SettingsController::class, 'externalApi'])->name('external-api')->middleware('can:'.Settings::EXTERNAL_API_KEYS);
        Route::patch('/external-api', [SettingsController::class, 'updateExternalApi'])->name('external-api.update')->middleware('can:'.Settings::EXTERNAL_API_KEYS);

        // Sms  settings
        Route::prefix('/email-template')->name('email-template.')->group(function () {
            Route::get('/reset-password', 'emailTemplate')->name('reset-password')->middleware('can:'.Settings::EMAIL_TEMPLATE);
            Route::patch('/email-update', 'updateEmailTemplate')->name('email.update')->middleware('can:'.Settings::EMAIL_TEMPLATE);
        });

        Route::resource('tax', TaxSettingsController::class)->except(['show', 'create', 'edit'])->middleware('can:'.TaxSettings::TAX_SETTINGS);
        Route::resource('social-media', SocialMediaController::class)->except(['show', 'create', 'edit'])->middleware('can:'.SocialMedia::SOCIAL_MEDIA_SETTINGS);

    });

    Route::controller(TaxSettingsController::class)->prefix('/settings/tax')->name('settings.tax.')->group(function () {
        Route::get('/getList', 'getList')->name('getList');
        Route::patch('/status/{tax}', 'status')->name('status');
    });

    Route::controller(SocialMediaController::class)->prefix('/settings/social-media')->name('settings.social-media.')->group(function () {
        Route::get('/getList', 'getList')->name('getList');
        Route::patch('/status/{social_medium}', 'status')->name('status');
    });

    Route::controller(CmsPageController::class)
        ->prefix('/pages')->name('pages.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.CmsPage::LIST);
            Route::patch('statusUpdate/{page}', 'statusUpdate')->name('statusUpdate')->middleware('can:'.CmsPage::STATUS_UPDATE);
        });

    Route::controller(FaqController::class)
        ->prefix('/faq')->name('faq.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList');
            Route::patch('statusUpdate/{faq}', 'statusUpdate')->name('statusUpdate');
        });

    Route::controller(BannerController::class)
        ->prefix('/banner')->name('banner.')
        ->group(function () {
            Route::get('/getList', 'getList')->name('getList')->middleware('can:'.Banner::LIST);
            Route::get('/fixed', 'fixedBanners')->name('fixedBanners')->middleware('can:'.Banner::LIST);
            Route::patch('/statusUpdate/{banner}', 'statusUpdate')->name('statusUpdate')->middleware('can:'.Banner::STATUS_UPDATE);
        });
    Route::controller(SubscriberController::class)
        ->prefix('/subscriber')->name('subscriber.')
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:'.Subscriber::LIST);
            Route::get('/getList', 'getList')->name('getList')->middleware('can:'.Subscriber::LIST);
            Route::delete('/destroy/{subscriber}', 'destroy')->name('destroy');
            Route::get('/newsletter/unsubscribe/{subscriber}', 'toggleSubscribe')->name('unsubscribe');
            Route::post('/store-subscriber', 'store')->name('store');
        });

    Route::controller(NewsletterController::class)
        ->prefix('/newsletter')->name('newsletter.')
        ->group(function () {
            Route::get('/index', 'index')->name('index')->middleware('can:'.Newsletter::LIST);
            Route::get('/create', 'create')->name('create')->middleware('can:'.Newsletter::CREATE);
            Route::post('/store', 'store')->name('store.mail')->middleware('can:'.Newsletter::CREATE);
            Route::get('/getList', 'getList')->name('mail.List')->middleware('can:'.Newsletter::LIST);
            Route::delete('/destroy/{newsletter}', 'destroyMail')->name('destroy');
            Route::get('/edit/{newsletter}', 'edit')->name('edit')->middleware('can:'.Newsletter::UPDATE);
            Route::patch('/update/{newsletter}', 'update')->name('update')->middleware('can:'.Newsletter::UPDATE);
            Route::get('/{newsletter}', 'show')->name('show');

        });

    Route::controller(TagController::class)
        ->prefix('/tags')->name('tags.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.Tag::LIST);
            Route::patch('/status/{tags}', 'status')->name('status')->middleware('can:'.Tag::STATUS_UPDATE);
        });

    Route::controller(ProductController::class)
        ->prefix('/products')->name('products.')
        ->group(function () {
            Route::get('/index', 'index')->name('index')->middleware('can:'.Product::LIST);
            Route::get('/getList', 'getList')->name('get.list')->middleware('can:'.Product::LIST);
            Route::get('/create', 'create')->name('create')->middleware('can:'.Product::CREATE);
            Route::post('/store', 'store')->name('store')->middleware('can:'.Product::CREATE);
            Route::get('/edit/{product}', 'edit')->name('edit')->middleware('can:'.Product::UPDATE);
            Route::patch('/update/{product}', 'update')->name('update')->middleware('can:'.Product::UPDATE);
            Route::delete('/destroy/{product}', 'destroy')->name('destroy')->middleware('can:'.Product::DELETE);
            Route::patch('/status/{product}', 'statusUpdate')->name('status.update')->middleware('can:'.Product::STATUS_UPDATE);
            Route::patch('/featured/{product}', 'featuredUpdate')->name('featured.update')->middleware('can:'.Product::FEATURE_STATUS_UPDATE);
            Route::patch('/new-arrival/{product}', 'newArrivalUpdate')->name('new-arrival.update')->middleware('can:'.Product::NEW_ARRIVAL_STATUS_UPDATE);
            Route::delete('/multiple-image/{image}', 'deleteMultipleImage')->name('multiple.image.delete')->middleware('can:'.Product::DELETE);
            Route::get('/{product}', 'show')->name('show')->middleware('can:'.Product::SHOW);
            Route::get('/get-tax/{product}', 'getTax')->name('tax.get')->middleware('can:'.Product::SHOW);
            Route::get('/check-stock/{product}', 'checkStock')->name('check.stock')->middleware('can:'.Product::SHOW);

        });

    Route::controller(OrderController::class)
        ->prefix('/orders')->name('orders.')
        ->group(function () {
            Route::get('getList', 'getList')->name('getList')->middleware('can:'.Order::LIST);
            Route::get('getUserOrderList/{user}', 'getUserOrderList')->name('getUserOrderList')->middleware('can:' . Order::LIST);
            Route::get('create', 'create')->name('create');
            Route::patch('/status/{order}', 'status')->name('status')->middleware('can:'.Order::STATUS_UPDATE);
            Route::patch('/cancel-request/{order}', 'cancelRequestUpdate')->name('cancel.request.update')->middleware('can:'.Order::STATUS_UPDATE);
            Route::get('/invoice/stream/{order}', 'invoicePdfStream')->name('invoice.pdf.stream')->middleware('can:'.Order::DETAILS_VIEW);
            Route::get('/invoice/download/{order}', 'invoicePdfDownload')->name('invoice.pdf.download')->middleware('can:'.Order::DETAILS_VIEW);
            Route::patch('/payment-status/{order}', 'paymentStatusUpdate')->name('payment.status')->middleware('can:'.Order::STATUS_UPDATE);
            Route::patch('/status/{order}', 'status')->name('status')->middleware('can:'.Order::STATUS_UPDATE);
            Route::patch('/cancel-request/{order}', 'cancelRequestUpdate')->name('cancel.request.update')->middleware('can:'.Order::STATUS_UPDATE);
            Route::get('/invoice/stream/{order}', 'invoicePdfStream')->name('invoice.pdf.stream')->middleware('can:'.Order::DETAILS_VIEW);
            Route::get('/invoice/download/{order}', 'invoicePdfDownload')->name('invoice.pdf.download')->middleware('can:'.Order::DETAILS_VIEW);
            Route::patch('/payment-status/{order}', 'paymentStatusUpdate')->name('payment.status')->middleware('can:'.Order::STATUS_UPDATE);
            Route::patch('/gift-status/{order}', 'giftStatusUpdate')->name('gift.status')->middleware('can:'.Order::GIFT_STATUS_UPDATE);
        });

    Route::controller(TransactionController::class)
        ->prefix('/transactions')->name('transactions.')
        ->group(function () {
            Route::get('payment/success/{order}', 'paymentSuccess')->name('payment.success');
            Route::get('payment/fail/{order}', 'paymentFail')->name('payment.fail');
        });



    // Delivery Schedule
    Route::controller(DeliveryScheduleController::class)
        ->prefix('/delivery-schedule')->name('delivery-schedule.')
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:'.DeliverySchedule::LIST);
            Route::get('/getList', 'getList')->name('getList')->middleware('can:'.DeliverySchedule::LIST);
            Route::patch('/status/{delivery_schedule}', 'statusUpdate')->name('status')->middleware('can:'.DeliverySchedule::STATUS_UPDATE);
            Route::get('/', 'index')->name('index')->middleware('can:'.DeliverySchedule::LIST);
            Route::get('/getList', 'getList')->name('getList')->middleware('can:'.DeliverySchedule::LIST);
            Route::patch('/status/{delivery_schedule}', 'statusUpdate')->name('status')->middleware('can:'.DeliverySchedule::STATUS_UPDATE);
        });
    Route::controller(CampaignController::class)
        ->prefix('/campaign')->name('campaign.')
        ->group(function () {
            Route::get('/', 'index')->name('index')->middleware('can:'.Campaign::LIST);
            Route::get('/getList', 'getList')->name('get.list')->middleware('can:'.Campaign::LIST);
            Route::get('/create', 'create')->name('create')->middleware('can:'.Campaign::CREATE);
            Route::post('/store', 'store')->name('store')->middleware('can:'.Campaign::CREATE);
            Route::get('/edit/{campaign}', 'edit')->name('edit')->middleware('can:'.Campaign::UPDATE);
            Route::patch('/status/{campaign}', 'statusUpdate')->name('status.update')->middleware('can:'.Campaign::STATUS_UPDATE);
            Route::delete('/destroy/{campaign}', 'destroy')->name('destroy')->middleware('can:'.Campaign::DELETE);
            Route::patch('/update/{campaign}', 'update')->name('update')->middleware('can:'.Campaign::UPDATE);
            Route::get('/', 'index')->name('index')->middleware('can:'.Campaign::LIST);
            Route::get('/getList', 'getList')->name('get.list')->middleware('can:'.Campaign::LIST);
            Route::get('/create', 'create')->name('create')->middleware('can:'.Campaign::CREATE);
            Route::post('/store', 'store')->name('store')->middleware('can:'.Campaign::CREATE);
            Route::get('/edit/{campaign}', 'edit')->name('edit')->middleware('can:'.Campaign::UPDATE);
            Route::patch('/status/{campaign}', 'statusUpdate')->name('status.update')->middleware('can:'.Campaign::STATUS_UPDATE);
            Route::delete('/destroy/{campaign}', 'destroy')->name('destroy')->middleware('can:'.Campaign::DELETE);
            Route::patch('/update/{campaign}', 'update')->name('update')->middleware('can:'.Campaign::UPDATE);
        });

    Route::controller(AddressController::class)
        ->prefix('/addresses')->name('addresses.')
        ->group(function () {
            Route::get('/getList/{user}', 'getList')->name('getList')->middleware('can:'.Address::LIST);
        });

    Route::controller(ReportController::class)
        ->prefix('/reports')->name('reports.')
        ->group(function () {

            Route::prefix('/sales')->name('sales.')->group(function () {
                Route::get('/', 'salesIndex')->name('index')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/getList', 'getSalesList')->name('getList')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/export/{type};', 'exportSales')->name('export')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/', 'salesIndex')->name('index')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/getList', 'getSalesList')->name('getList')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/export/{type};', 'exportSales')->name('export')->middleware('can:'.Settings::REPORTS_LIST);
            });

            Route::prefix('/transactions')->name('transactions.')->group(function () {
                Route::get('/', 'transactionIndex')->name('index')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/getList', 'getTransactionList')->name('getList')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/export/{type};', 'exportTransaction')->name('export')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/', 'transactionIndex')->name('index')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/getList', 'getTransactionList')->name('getList')->middleware('can:'.Settings::REPORTS_LIST);
                Route::get('/export/{type};', 'exportTransaction')->name('export')->middleware('can:'.Settings::REPORTS_LIST);
            });
        });

    Route::controller(UserSearchController::class)
        ->prefix('/user-searches')->name('user-searches.')
        ->group(function () {
            Route::get('/getList', 'getList')->name('getList')->middleware('can:'.UserSearch::LIST);
            Route::get('/getList', 'getList')->name('getList')->middleware('can:'.UserSearch::LIST);
        });

    //Email Routes
    Route::get('/send-mail', [OrderMailController::class, 'sendOrderConfirmation']);

    // Email Routes
    Route::get('/send-mail', [OrderMailController::class, 'sendOrderConfirmation']);

    Route::controller(DealController::class)->prefix('/deals')->name('deals.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:'.Deal::LIST);
        Route::get('/create', 'create')->name('create')->middleware('can:'.Deal::CREATE);
        Route::post('/store', 'store')->name('store')->middleware('can:'.Deal::CREATE);
        Route::get('/edit/{deal}', 'edit')->name('edit')->middleware('can:'.Deal::UPDATE);
        Route::put('/update/{deal}', 'update')->name('update')->middleware('can:'.Deal::UPDATE);
        Route::get('/details/{deal}', 'show')->name('show')->middleware('can:'.Deal::LIST);
        Route::get('/getList', 'getList')->name('getList')->middleware('can:'.Deal::LIST);
        Route::patch('/status/{deal}', 'statusUpdate')->name('status.update')->middleware('can:'.Deal::STATUS_UPDATE);
        Route::delete('/destroy/{deal}', 'destroy')->name('destroy')->middleware('can:'.Deal::DELETE);
        Route::delete('/product/destroy/{deal}/{product}', 'productDestroy')->name('product.destroy')->middleware('can:'.Deal::DELETE);
        Route::get('/details', 'detailsList')->name('detailsList');

    });

    // Resourceful controllers
    Route::resource('role', RoleManagementController::class);
    Route::resource('users', UserController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubcategoryController::class);
    Route::resource('subsub-category', SubsubCategoryController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('tags', TagController::class);
    Route::resource('brand', BrandController::class)->except('show');
    Route::resource('faq', FaqController::class)->except('show');
    Route::resource('promo', PromoController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('pages', CmsPageController::class);
    Route::resource('banner', BannerController::class)->except('show');
    Route::resource('addresses', AddressController::class)->except('index', 'show');
    Route::resource('user-searches', UserSearchController::class)->except(['create', 'store', 'show', 'edit', 'update']);
    Route::get('/addresses/create/{user}', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses/store/{user}', [AddressController::class, 'store'])->name('addresses.store');

    Route::resource('feature-highlights', FeatureHighlightController::class);
    Route::get('/feature-highlights-list', [FeatureHighlightController::class, 'getList'])->name('feature-highlights.get.list');
   Route::patch('/feature-highlights/status/{feature_highlight}', [FeatureHighlightController::class,'statusUpdate'])->name('feature-highlights.status.update');
});