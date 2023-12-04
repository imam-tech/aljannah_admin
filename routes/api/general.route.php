<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\GeneralController;

Route::group(['prefix' => 'general'], function () {
    Route::group(['prefix' => 'address'], function () {
        Route::get('search-subdistrict', [AddressController::class, 'searchSubdistrict']);
    });
    Route::get('jenjang', [GeneralController::class, 'jenjang']);
    Route::get('level', [GeneralController::class, 'level']);
    Route::get('kelas', [GeneralController::class, 'kelas']);
});