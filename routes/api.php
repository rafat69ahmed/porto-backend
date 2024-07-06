<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IpnHandlerController;


Route::group(['prefix' => 'v1'], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::post('products', 'store');
        Route::get('products', 'index');
        Route::get('products/{id}', 'show');
        Route::delete('products/{id}', 'destroy');
    });
    Route::controller(AddressController::class)->group(function () {
        Route::post('addresses', 'store');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::post('orders', 'store');
        Route::get('orders', 'index');
    });
    Route::controller(IpnHandlerController::class)->group(function () {
        Route::post('invoice', 'ipnStatus');
    });
});
