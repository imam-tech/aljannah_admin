<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeacherController;

Route::group(['prefix' => 'teacher'], function () {
    Route::get('', [TeacherController::class, 'index']);
    Route::post('', [TeacherController::class, 'store']);
    Route::get('wali-kelas', [TeacherController::class, 'indexWaliKelas']);
    Route::post('wali-kelas', [TeacherController::class, 'storeWaliKelas']);
});