<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\SubdistrictController;
use App\Models\Province;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/submit-login', [LoginController::class, 'submitLogin']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);

    Route::group(['prefix' => 'manager'], function () {
        Route::get('province', [ProvinceController::class, 'index']);
        Route::get('province/list', [ProvinceController::class, 'list']);
        Route::get('province/edit/{id}', [ProvinceController::class, 'edit']);
        Route::post('province/store', [ProvinceController::class, 'store']);
        Route::put('province/update/{id}', [ProvinceController::class, 'destroy']);
        Route::delete('province/destroy/{id}', [ProvinceController::class, 'destroy']);


        // Route::get('city/list', [CityController::class, 'list']);

        // Route::get('district/list', [DistrictController::class, 'list']);
        // Route::get('subdistrict/list', [SubdistrictController::class, 'list']);
    });
});
