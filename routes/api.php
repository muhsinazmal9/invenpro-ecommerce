<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DealController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\bKashController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PromoController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\CmsPageController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\CampaignController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\WishlistController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\SubscriberController;
use App\Http\Controllers\Api\V1\UserSearchController;
use App\Http\Controllers\Api\V1\SubCategoryController;
use App\Http\Controllers\Api\V1\TransactionController;
use App\Http\Controllers\Api\V1\RecentReviewController;
use App\Http\Controllers\Api\V1\Auth\PasswordController;
use App\Http\Controllers\Api\V1\DeliveryScheduleController;
use App\Http\Controllers\Api\V1\FeatureHighlightController;
use App\Http\Controllers\Api\V1\Auth\RegistrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::controller(RegistrationController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/resend-verification-otp', 'resendVerificationOtp')->middleware('auth:sanctum');
    Route::post('/verify-otp', 'verifyOtp')->middleware('auth:sanctum');
});

Route::post('login', [LoginController::class, 'login']);
Route::post('social-login', [LoginController::class, 'social_login']);

Route::post('/forget-password', [PasswordController::class, 'forgetPassword']);
Route::post('/check-otp', [PasswordController::class, 'checkOtp']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);
Route::controller(PasswordController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/set-password', 'setPassword');
});
Route::controller(CheckoutController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', 'checkout');
});

Route::controller(TransactionController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/payment/success/{order}', 'paymentSuccess');
    Route::get('/payment/failed/{order}', 'paymentFailed');
    Route::post('/payment/bkash/{order}', 'storeBkashPaymentTransaction');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-password', [PasswordController::class, 'changePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::controller(UserController::class)->prefix('user/')->group(function () {
        Route::get('/details', 'userDetails');
        Route::put('/update', 'updatePersonalInformation');
    });

    // Address routes
    Route::controller(AddressController::class)->group(function () {
        Route::get('/addresses', 'getAddresses');
        Route::get('addresses/{address}', 'show');
        Route::post('addresses', 'store');
        Route::patch('addresses/{address}', 'update');
        Route::delete('addresses/{address}', 'destroy');
    });

    // Orders routes
    Route::controller(OrderController::class)->prefix('/orders')->group(function () {
        Route::get('/', 'list');
        Route::get('/details/{order}', 'details');
        Route::post('/track', 'trackOrder')->withoutMiddleware('auth:sanctum');
        Route::post('/review/{order}', 'storeReview');
        Route::post('/cancel/{order}', 'cancelOrder');
    });

    Route::controller(WishlistController::class)
    ->prefix('wishlists')
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::delete('/delete/{product_id}', 'destroy');
    });
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'list');
    Route::get('/categories/{category}', 'details');
});

Route::controller(BrandController::class)->group(function () {
    Route::get('/brands', 'list');
});

Route::controller(SubCategoryController::class)->group(function () {
    Route::get('/subcategories', '__invoke');
    Route::get('/subcategories/{subcategory}', 'details');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'list');
    Route::get('/products/recently-viewed', 'recentlyViewed');
    Route::get('/products/{product}', 'details');
});

// recent reviews
Route::controller(RecentReviewController::class)->group(function () {
    Route::get('/recent-reviews', 'list');
});

Route::controller(PromoController::class)->group(function () {
    Route::get('promos', 'list');
    Route::get('promos/{code}', 'detail');
});

Route::controller(CmsPageController::class)->group(function () {
    Route::get('pages', 'getCmsPage');
    Route::get('pages/{cmsPage}', 'cmsPageDetails');
});

Route::controller(UserSearchController::class)->group(function () {
    Route::get('/product/search', 'productSearches');
    // Route::post('/user-searches', 'storeUserSearch');
    Route::get('/product/search/popular', 'getPopularSearches');
});

Route::controller(SubscriberController::class)->group(function () {
    Route::post('/newsletter/subscribe', 'subscribe');
});

Route::controller(DealController::class)->group(function () {
    Route::get('/deals', 'list');
    Route::get('/deals/{deal}', 'details');
});

Route::get('/banners', BannerController::class);
Route::get('/delivery-schedule', DeliveryScheduleController::class);

Route::get('/campaigns', CampaignController::class);
Route::get('/campaigns/{slug}', [CampaignController::class, 'campaignProducts']);
Route::get('/settings', SettingController::class);
Route::get('/feature-highlights', FeatureHighlightController::class);
