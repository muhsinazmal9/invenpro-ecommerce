<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;

Route::name('guest.')->group(function () {
    Route::get('/newsletter/unsubscribe/{subscriber}', [SubscriberController::class, 'toggleSubscribe'])->name('unsubscribe');
});

Route::get('/', HomeController::class);

Route::get('/category/{slug}', [ProductController::class, 'category'])->name('frontend.category');
