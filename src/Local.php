<?php

namespace Laraflow\Local;

class Local
{
    /**
     * @return \Laraflow\Local\Services\CountryService
     */
    public function country()
    {
        return app(\Laraflow\Local\Services\CountryService::class);
    }

    /**
     * @return \Laraflow\Local\Services\StateService
     */
    public function state()
    {
        return app(\Laraflow\Local\Services\StateService::class);
    }

    /**
     * @return \Laraflow\Local\Services\CityService
     */
    public function city()
    {
        return app(\Laraflow\Local\Services\CityService::class);
    }

    /**
     * @return \Laraflow\Local\Services\CurrencyService
     */
    public function currency()
    {
        return app(\Laraflow\Local\Services\CurrencyService::class);
    }

    /**
     * @return \Laraflow\Local\Services\RegionService
     */
    public function region()
    {
        return app(\Laraflow\Local\Services\RegionService::class);
    }

    /**
     * @return \Laraflow\Local\Services\SubregionService
     */
    public function subregion()
    {
        return app(\Laraflow\Local\Services\SubregionService::class);
    }

    /**
     * @return \Laraflow\Local\Services\TownService
     */
    public function town()
    {
        return app(\Laraflow\Local\Services\TownService::class);
    }

    //** Crud Service Method Point Do not Remove **//







}
