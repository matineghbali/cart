<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ProductController;

Route::prefix('v1')->as('v1.')->group(function () {
    Route::post('/product', [ProductController::class, 'store'])->name('products.store');
    Route::apiresource('carts', CartController::class);
});
