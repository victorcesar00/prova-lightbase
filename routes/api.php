<?php

use Illuminate\Support\Facades\Route;

Route::group([ 'prefix' => 'cliente' ], function() {
    Route::post('/', [CheckoutController::class, 'createOrder']);

    Route::get('/createFormCode/{prodId}', [CheckoutController::class, 'createFormCode']);
});
