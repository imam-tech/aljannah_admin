<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;

Route::group(['prefix' => 'parent'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'loginParent']);
    });


    Route:: group(['prefix' => 'profile', 'middleware' => 'auth:parent'], function () {
        Route::get('/', [ProfileController::class, 'index']);
    });
});