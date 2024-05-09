<?php

namespace Laraflow\Local\Facades;

use Illuminate\Support\Facades\Facade;
use Laraflow\Local\Services\CityService;
use Laraflow\Local\Services\CountryService;
use Laraflow\Local\Services\CurrencyService;
use Laraflow\Local\Services\RegionService;
use Laraflow\Local\Services\StateService;
use Laraflow\Local\Services\SubregionService;
use Laraflow\Local\Services\TownService;

/**
 * @method static CountryService country()
 * @method static StateService state()
 * @method static CityService city()
 * @method static CurrencyService currency()
 * @method static RegionService region()
 * @method static SubregionService subregion()
 * @method static TownService town()
 *                                   // Crud Service Method Point Do not Remove //
 *
 * @see \Laraflow\Local\Local
 */
class Local extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Laraflow\Local\Local::class;
    }
}
