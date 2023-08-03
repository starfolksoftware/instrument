<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Currency;

interface DeletesCurrencies
{
    /**
     * Delete an existing currency.
     */
    public function __invoke(Model $user, Currency $currency): void;
}
