<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
});
