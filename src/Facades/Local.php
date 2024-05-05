<?php

namespace Laraflow\Local\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Laraflow\Local\Services\CountryService country()
 * @method static \Laraflow\Local\Services\StateService state()
 * @method static \Laraflow\Local\Services\CityService city()
 * @method static \Laraflow\Local\Services\CurrencyService currency()
 * @method static \Laraflow\Local\Services\RegionService region()
 * @method static \Laraflow\Local\Services\SubregionService subregion()
 * @method static \Laraflow\Local\Services\TownService town()
 * // Crud Service Method Point Do not Remove //
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
