<?php

namespace Morbzeno\PruebaDePlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Morbzeno\PruebaDePlugin\PruebaDePlugin
 */
class PruebaDePlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Morbzeno\PruebaDePlugin\PruebaDePlugin::class;
    }
}
