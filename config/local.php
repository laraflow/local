<?php

// config for Laraflow/Local
use Laraflow\Local\Models\City;
use Laraflow\Local\Models\Country;
use Laraflow\Local\Models\Currency;
use Laraflow\Local\Models\Region;
use Laraflow\Local\Models\State;
use Laraflow\Local\Models\Subregion;
use Laraflow\Local\Models\Town;
use Laraflow\Local\Repositories\Eloquent\CityRepository;
use Laraflow\Local\Repositories\Eloquent\CountryRepository;
use Laraflow\Local\Repositories\Eloquent\CurrencyRepository;
use Laraflow\Local\Repositories\Eloquent\RegionRepository;
use Laraflow\Local\Repositories\Eloquent\StateRepository;
use Laraflow\Local\Repositories\Eloquent\SubregionRepository;
use Laraflow\Local\Repositories\Eloquent\TownRepository;

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Module APIs
    |--------------------------------------------------------------------------
    | This setting enable the API will be available or not
    */
    'rest_api_' => env('PACKAGE_Local_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Local Group Root Prefix
    |--------------------------------------------------------------------------
    |
    | This value will be added to all your routes from this package
    | Example: APP_URL/{root_prefix}/api/local/action
    |
    | Note: while adding prefix add closing ending slash '/'
    */

    'root_prefix' => 'test/',

    /*
    |--------------------------------------------------------------------------
    | Country Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'country_model' => Country::class,

    /*
    |--------------------------------------------------------------------------
    | State Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'state_model' => State::class,

    /*
    |--------------------------------------------------------------------------
    | City Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'city_model' => City::class,

    /*
    |--------------------------------------------------------------------------
    | Currency Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'currency_model' => Currency::class,

    /*
    |--------------------------------------------------------------------------
    | Region Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'region_model' => Region::class,

    /*
    |--------------------------------------------------------------------------
    | Subregion Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'subregion_model' => Subregion::class,

    /*
    |--------------------------------------------------------------------------
    | Town Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'town_model' => Town::class,

    //** Model Config Point Do not Remove **//

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | This value will be used across systems where a repository instance is needed
    */

    'repositories' => [
        \Laraflow\Local\Interfaces\CountryRepository::class => CountryRepository::class,

        \Laraflow\Local\Interfaces\StateRepository::class => StateRepository::class,

        \Laraflow\Local\Interfaces\CityRepository::class => CityRepository::class,

        \Laraflow\Local\Interfaces\CurrencyRepository::class => CurrencyRepository::class,

        \Laraflow\Local\Interfaces\RegionRepository::class => RegionRepository::class,

        \Laraflow\Local\Interfaces\SubregionRepository::class => SubregionRepository::class,

        \Laraflow\Local\Interfaces\TownRepository::class => TownRepository::class,

        //** Repository Binding Config Point Do not Remove **//
    ],

];
