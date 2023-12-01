<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PpdbController;

Route:: group(['prefix' => 'ppdb'], function () {
    Route::post('/', [PpdbController::class, 'store']);
    Route::get('/jenjang-data', [PpdbController::class, 'jenjangDataFunction']);
});