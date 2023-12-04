<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('ppdb', [DashboardController::class, 'ppdb']);
    Route::get('income-ppdb', [DashboardController::class, 'incomePpdb']);
});