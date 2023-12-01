<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/app/{any?}', [AppController::class, 'index'])->where('any', '.*');
Route::get('/auth/{any?}', [AppController::class, 'index'])->where('any', '.*');
Route::get('/online-admission/{any?}', [AppController::class, 'index'])->where('any', '.*');
Route::get('/', function() {
    return redirect(url('app'));
});
Route::get('/parent/app/{any?}', [AppController::class, 'indexParent'])->where('any', '.*');
Route::get('/parent/auth/{any?}', [AppController::class, 'indexParent'])->where('any', '.*');
Route::get('/parent/', function() {
    return redirect(url('parent/app'));
});
