<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JabatanController;

Route::group(['prefix' => 'jabatan'], function () {
    Route::get('', [JabatanController::class, 'index']);
    Route::post('', [JabatanController::class, 'store']);
});