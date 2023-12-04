<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PpdbController;

Route:: group(['prefix' => 'ppdb'], function () {
    Route::post('/', [PpdbController::class, 'store']);
    Route::get('/', [PpdbController::class, 'index']);
    Route::get('/{nomorPendaftaran}/detail', [PpdbController::class, 'detail']);
    Route::get('/jenjang-data', [PpdbController::class, 'jenjangDataFunction']);
    Route::post('/search-registration', [PpdbController::class, 'searchRegistration']);
    Route::post('/verify', [PpdbController::class, 'verify']);
    Route::post('/{type}/upload-proven', [PpdbController::class, 'uploadProven']);
    Route::get('/{regisId}/{id}/reupload-proven/{type}', [PpdbController::class, 'reuploadProven']);
    Route::post('/{type}/verify-proven', [PpdbController::class, 'verifyProven']);
    Route::post('/verify-interview', [PpdbController::class, 'verifyInterview']);
    Route::post('/import-received-student', [PpdbController::class, 'importReceivedStudent']);
    Route::post('/import-data', [PpdbController::class, 'importData']);
});