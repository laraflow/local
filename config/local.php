<?php

// config for Laraflow/Local
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
    'country_model' => \Laraflow\Local\Models\Country::class,

    /*
    |--------------------------------------------------------------------------
    | State Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'state_model' => \Laraflow\Local\Models\State::class,

    /*
    |--------------------------------------------------------------------------
    | City Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'city_model' => \Laraflow\Local\Models\City::class,

    /*
    |--------------------------------------------------------------------------
    | Currency Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'currency_model' => \Laraflow\Local\Models\Currency::class,

    /*
    |--------------------------------------------------------------------------
    | Region Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'region_model' => \Laraflow\Local\Models\Region::class,

    /*
    |--------------------------------------------------------------------------
    | Subregion Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'subregion_model' => \Laraflow\Local\Models\Subregion::class,

    /*
    |--------------------------------------------------------------------------
    | Town Model
    |--------------------------------------------------------------------------
    |
    | This value will be used to across system where model is needed
    */
    'town_model' => \Laraflow\Local\Models\Town::class,

    //** Model Config Point Do not Remove **//

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | This value will be used across systems where a repositoy instance is needed
    */

    'repositories' => [
        \Laraflow\Local\Interfaces\CountryRepository::class => \Laraflow\Local\Repositories\Eloquent\CountryRepository::class,

        \Laraflow\Local\Interfaces\StateRepository::class => \Laraflow\Local\Repositories\Eloquent\StateRepository::class,

        \Laraflow\Local\Interfaces\CityRepository::class => \Laraflow\Local\Repositories\Eloquent\CityRepository::class,

        \Laraflow\Local\Interfaces\CurrencyRepository::class => \Laraflow\Local\Repositories\Eloquent\CurrencyRepository::class,

        \Laraflow\Local\Interfaces\RegionRepository::class => \Laraflow\Local\Repositories\Eloquent\RegionRepository::class,

        \Laraflow\Local\Interfaces\SubregionRepository::class => \Laraflow\Local\Repositories\Eloquent\SubregionRepository::class,

        \Laraflow\Local\Interfaces\TownRepository::class => \Laraflow\Local\Repositories\Eloquent\TownRepository::class,

        //** Repository Binding Config Point Do not Remove **//
    ],

];
