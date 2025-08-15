<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix('user')->controller(AuthController::class)->group(function () {
    Route::post('login','login');
    Route::post('register','register');
    Route::get('profile','profile');
    Route::put('update','update');
    Route::post('logout','logout');
});

Route::prefix('contact-us')->controller(App\Http\Controllers\Api\ContuctUsController::class)->group(function () {
    Route::post('store', 'store');
    Route::get('show/{id}', 'show');
    // 
});

Route::prefix('kids')->controller(App\Http\Controllers\Api\KidsController::class)->group(function () {
    Route::post('store', 'store');
    Route::get('index', 'index');
    Route::get('show/{id}', 'show');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}', 'delete');
});