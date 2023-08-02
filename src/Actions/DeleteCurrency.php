<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Contracts\DeletesCurrencies;
use StarfolkSoftware\Instrument\Currency;
use StarfolkSoftware\Instrument\Events\CurrencyDeleted;
use StarfolkSoftware\Instrument\Events\DeletingCurrency;

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