<?php

namespace StarfolkSoftware\Instrument\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \StarfolkSoftware\Instrument\Instrument
 */
class Instrument extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'instrument';
    }
}
