<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Laraflow\Local\Http\Controllers\CityController;
use Laraflow\Local\Http\Controllers\CountryController;
use Laraflow\Local\Http\Controllers\CurrencyController;
use Laraflow\Local\Http\Controllers\RegionController;
use Laraflow\Local\Http\Controllers\StateController;
use Laraflow\Local\Http\Controllers\SubregionController;
use Laraflow\Local\Http\Controllers\TownController;

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

        Route::apiResource('countries', CountryController::class);
        Route::post('countries/{country}/restore', [CountryController::class, 'restore'])->name('countries.restore');

        Route::apiResource('states', StateController::class);
        Route::post('states/{state}/restore', [StateController::class, 'restore'])->name('states.restore');

        Route::apiResource('cities', CityController::class);
        Route::post('cities/{city}/restore', [CityController::class, 'restore'])->name('cities.restore');

        Route::apiResource('currencies', CurrencyController::class);
        Route::post('currencies/{currency}/restore', [CurrencyController::class, 'restore'])->name('currencies.restore');

        Route::apiResource('regions', RegionController::class);
        Route::post('regions/{region}/restore', [RegionController::class, 'restore'])->name('regions.restore');

        Route::apiResource('subregions', SubregionController::class);
        Route::post('subregions/{subregion}/restore', [SubregionController::class, 'restore'])->name('subregions.restore');

        Route::apiResource('towns', TownController::class);
        Route::post('towns/{town}/restore', [TownController::class, 'restore'])->name('towns.restore');

        //DO NOT REMOVE THIS LINE//
    });
}
