<?php

use App\Http\Controllers\API\v1\AuthenticationController;
use App\Http\Controllers\API\v1\BookController;
use App\Http\Controllers\API\v1\CategoryController;
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
    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('books', BookController::class);
        Route::apiResource('categories', CategoryController::class);

        Route::post('/logout', [AuthenticationController::class, 'logout']);
        Route::get('/profile', [AuthenticationController::class, 'profile']);
    });

    Route::middleware(GuestMiddleware::class)->group(function () {
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::post('/register', [AuthenticationController::class, 'register']);
    });
});
