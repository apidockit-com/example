<?php

use App\Http\Basket\BasketRetrieveController;
use App\Http\Order\OrderCreateController;
use App\Http\Order\OrderDeleteController;
use App\Http\Order\OrderListController;
use App\Http\Order\OrderRetrieveController;
use App\Http\Order\OrderUpdateController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function () {
    Route::get('/', OrderListController::class)->name('list');
    Route::post('/', OrderCreateController::class)->name('create');
    Route::get('/{id}', OrderRetrieveController::class)->name('retrieve');
    Route::patch('/{id}', OrderUpdateController::class)->name('update');
    Route::delete('/{id}', OrderDeleteController::class)->name('delete');
});

/*Route::prefix('basket')->group(function () {
    Route::get('/', BasketRetrieveController::class)->name('list');
});*/
