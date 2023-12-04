<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

Route::group(['prefix' => 'student'], function () {
    Route::get('', [StudentController::class, 'index']);
    Route::get('{id}/detail', [StudentController::class, 'detail']);
});