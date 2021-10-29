<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Manager\CityController;
use App\Http\Controllers\Manager\DistrictController;
use App\Http\Controllers\Manager\ProvinceController;
use App\Http\Controllers\Manager\SubdistrictController;
use App\Http\Controllers\Utils\RegionController;
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
        Route::put('province/update/{id}', [ProvinceController::class, 'update']);
        Route::delete('province/destroy/{id}', [ProvinceController::class, 'destroy']);

        Route::get('city', [CityController::class, 'index']);
        Route::get('city/list', [CityController::class, 'list']);
        Route::get('city/edit/{id}', [CityController::class, 'edit']);
        Route::post('city/store', [CityController::class, 'store']);
        Route::put('city/update/{id}', [CityController::class, 'update']);
        Route::delete('city/destroy/{id}', [CityController::class, 'destroy']);

        Route::get('district', [DistrictController::class, 'index']);
        Route::get('district/list', [DistrictController::class, 'list']);
        Route::get('district/edit/{id}', [DistrictController::class, 'edit']);
        Route::post('district/store', [DistrictController::class, 'store']);
        Route::put('district/update/{id}', [DistrictController::class, 'update']);
        Route::delete('district/destroy/{id}', [DistrictController::class, 'destroy']);

        Route::get('subdistrict', [SubdistrictController::class, 'index']);
        Route::get('subdistrict/list', [SubdistrictController::class, 'list']);
        Route::get('subdistrict/edit/{id}', [SubdistrictController::class, 'edit']);
        Route::post('subdistrict/store', [SubdistrictController::class, 'store']);
        Route::put('subdistrict/update/{id}', [SubdistrictController::class, 'update']);
        Route::delete('subdistrict/destroy/{id}', [SubdistrictController::class, 'destroy']);

        Route::get('region/get-city-provid/{id}', [RegionController::class, 'getCityByProvId']);
        Route::get('region/get-district-cityid/{id}', [RegionController::class, 'getDistrictByCityId']);
    });
});
