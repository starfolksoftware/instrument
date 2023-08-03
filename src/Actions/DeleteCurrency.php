<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Contracts\DeletesCurrencies;
use Instrument\Currency;
use Instrument\Events\CurrencyDeleted;
use Instrument\Events\DeletingCurrency;

class DeleteCurrency implements DeletesCurrencies
{
    /**
     * Delete a currency.
     */
    public function __invoke(Model $user, Currency $currency): void
    {
        event(new DeletingCurrency(user: $user, currency: $currency));

        $currency->delete();

        event(new CurrencyDeleted(user: $user, currency: $currency));
    }
}
