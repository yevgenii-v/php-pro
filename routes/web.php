<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payment_stripe', function () {
    return view('payment_stripe');
});

Route::get('/payment_paypal', function () {
    return view('payment_paypal');
});

Route::get('/payment_liqpay', function () {
    return view('payment_liqpay');
});
