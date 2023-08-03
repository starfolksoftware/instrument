<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Currency;

interface UpdatesCurrencies
{
    /**
     * Update an existing currency.
     */
    public function __invoke(Model $user, Currency $currency, array $data): Currency;
}
