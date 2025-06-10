<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// Route::middleware('web_install')->group(function () {
    Route::controller(SubscriberController::class)
        ->name('guest.')
        ->group(function () {
            Route::get('/newsletter/unsubscribe/{subscriber}', 'toggleSubscribe')->name('unsubscribe');
        });

    require_once __DIR__.'/frontend.php';
    require_once __DIR__.'/backend.php';
    require_once __DIR__.'/auth.php';
// });
