<?php

namespace Laraflow\Local\Facades;

use Illuminate\Support\Facades\Facade;

/**
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
