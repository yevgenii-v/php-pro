<?php

use App\Http\Controllers\API\v1\AuthenticationController;
use App\Http\Controllers\API\v1\BookController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\PaymentSystemController;
use App\Http\Middleware\API\GuestMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
//    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('booksIterator', [BookController::class, 'getDataByIterator']);
        Route::get('booksModel', [BookController::class, 'getDataByModel']);
        Route::apiResource('books', BookController::class);
        Route::get('categoryIterator/{category}', [CategoryController::class, 'showIterator']);
        Route::get('categoryModel/{category}', [CategoryController::class, 'showModel']);
        Route::apiResource('categories', CategoryController::class);

        Route::post('/logout', [AuthenticationController::class, 'logout']);
        Route::get('/profile', [AuthenticationController::class, 'profile']);

        Route::get('/categoriesWithCache', [CategoryController::class, 'cachedIndex']);
//    });

    Route::middleware(GuestMiddleware::class)->group(function () {
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::post('/register', [AuthenticationController::class, 'register']);
    });

    Route::get('payment/makePayment/{system}', [PaymentSystemController::class, 'createPayment']);
    Route::post('payment/confirm/{system}', [PaymentSystemController::class, 'confirmPayment'])
        ->name('payment.confirm');
});
