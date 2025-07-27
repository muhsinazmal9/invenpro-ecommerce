<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;

Route::name('guest.')->group(function () {
    // auths
    Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');

    Route::get('/newsletter/unsubscribe/{subscriber}', [SubscriberController::class, 'toggleSubscribe'])->name('unsubscribe');
});

Route::get('/', HomeController::class)->name('home');

Route::get('/category/{slug}', [ProductController::class, 'category'])->name('frontend.category');
Route::get('/product/{slug}', [ProductController::class, 'product'])->name('frontend.product');

