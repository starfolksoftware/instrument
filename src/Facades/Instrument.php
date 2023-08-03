<?php

namespace Instrument\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Instrument\Instrument
 */
class Instrument extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'instrument';
    }
}
