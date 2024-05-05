<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "API" middleware group. Enjoy building your API!
|
*/
if (Config::get('fintech.local.enabled')) {
    Route::prefix('local')->name('local.')->group(function () {

        Route::apiResource('countries', \Laraflow\Local\Http\Controllers\CountryController::class);
        Route::post('countries/{country}/restore', [\Laraflow\Local\Http\Controllers\CountryController::class, 'restore'])->name('countries.restore');

        Route::apiResource('states', \Laraflow\Local\Http\Controllers\StateController::class);
        Route::post('states/{state}/restore', [\Laraflow\Local\Http\Controllers\StateController::class, 'restore'])->name('states.restore');

        Route::apiResource('cities', \Laraflow\Local\Http\Controllers\CityController::class);
        Route::post('cities/{city}/restore', [\Laraflow\Local\Http\Controllers\CityController::class, 'restore'])->name('cities.restore');

        Route::apiResource('currencies', \Laraflow\Local\Http\Controllers\CurrencyController::class);
        Route::post('currencies/{currency}/restore', [\Laraflow\Local\Http\Controllers\CurrencyController::class, 'restore'])->name('currencies.restore');

        Route::apiResource('regions', \Laraflow\Local\Http\Controllers\RegionController::class);
        Route::post('regions/{region}/restore', [\Laraflow\Local\Http\Controllers\RegionController::class, 'restore'])->name('regions.restore');

        Route::apiResource('subregions', \Laraflow\Local\Http\Controllers\SubregionController::class);
        Route::post('subregions/{subregion}/restore', [\Laraflow\Local\Http\Controllers\SubregionController::class, 'restore'])->name('subregions.restore');

        Route::apiResource('towns', \Laraflow\Local\Http\Controllers\TownController::class);
        Route::post('towns/{town}/restore', [\Laraflow\Local\Http\Controllers\TownController::class, 'restore'])->name('towns.restore');

        //DO NOT REMOVE THIS LINE//
    });
}
