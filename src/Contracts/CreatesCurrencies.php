<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Currency;

interface CreatesCurrencies
{
    /**
     * Create a new currency.
     */
    public function __invoke(Model $user, array $data, int|string|null $teamId = null): Currency;
}
