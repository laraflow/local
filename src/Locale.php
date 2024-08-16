<?php

namespace Laraflow\Local;

use Laraflow\Local\Services\CityService;
use Laraflow\Local\Services\CountryService;
use Laraflow\Local\Services\CurrencyService;
use Laraflow\Local\Services\RegionService;
use Laraflow\Local\Services\StateService;
use Laraflow\Local\Services\SubregionService;
use Laraflow\Local\Services\TownService;

class Locale
{
    /**
     * @return CountryService
     */
    public function country()
    {
        return app(CountryService::class);
    }

    /**
     * @return StateService
     */
    public function state()
    {
        return app(StateService::class);
    }

    /**
     * @return CityService
     */
    public function city()
    {
        return app(CityService::class);
    }

    /**
     * @return CurrencyService
     */
    public function currency()
    {
        return app(CurrencyService::class);
    }

    /**
     * @return RegionService
     */
    public function region()
    {
        return app(RegionService::class);
    }

    /**
     * @return SubregionService
     */
    public function subregion()
    {
        return app(SubregionService::class);
    }

    /**
     * @return TownService
     */
    public function town()
    {
        return app(TownService::class);
    }

    //** Crud Service Method Point Do not Remove **//

}
