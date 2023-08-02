<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Currency;

interface UpdatesCurrencies
{
    /**
     * Update an existing currency.
     */
    public function __invoke(Model $user, Currency $currency, array $data): Currency;
}
