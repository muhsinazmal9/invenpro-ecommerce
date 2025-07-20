<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;

Route::name('guest.')->group(function () {
    Route::get('/newsletter/unsubscribe/{subscriber}', [SubscriberController::class, 'toggleSubscribe'])->name('unsubscribe');
});

Route::get('/', HomeController::class)->name('home');

Route::get('/category/{slug}', [ProductController::class, 'category'])->name('frontend.category');
Route::get('/product/{slug}', [ProductController::class, 'product'])->name('frontend.product');

