<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Middleware\CheckProudctQuantityForCart;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('sign-up', 'signUp');
    Route::post('sign-in', 'signIn');
    Route::post('sign-out', 'signOut')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class)->only('index', 'show');
    Route::controller(CartController::class)->prefix('cart/')->group(function () {
        Route::get('', 'getCart');
        Route::middleware(CheckProudctQuantityForCart::class)->group(function () {
            Route::post('add', 'add');
            Route::post('remove', 'remove');
            Route::post('increment', 'increment');
            Route::post('decrement', 'decrement');
        });
    });

    Route::post('order/create',[OrderController::class,'create']);
});
