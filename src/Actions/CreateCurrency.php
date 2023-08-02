<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\CreatesCurrencies;
use StarfolkSoftware\Instrument\Currency;
use StarfolkSoftware\Instrument\Events\CreatingCurrency;
use StarfolkSoftware\Instrument\Events\CurrencyCreated;
use StarfolkSoftware\Instrument\Instrument;

class CreateCurrency implements CreatesCurrencies
{
    /**
     * Create a new currency.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Currency
    {
        event(new CreatingCurrency(user: $user, data: $data));

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'decimal:0,8'],
            'precision' => ['nullable', 'integer', 'max:255'],
            'symbol' => ['nullable', 'string', 'max:255'],
            'symbol_position' => ['string', 'max:255', 'in:before,after'],
            'decimal_mark' => ['nullable', 'string', 'max:255'],
            'thousands_separator' => ['nullable', 'string', 'max:255'],
            'enabled' => ['boolean'],
        ])->validateWithBag('createCurrency');

        $fields = collect($data)->only([
            'name',
            'code',
            'rate',
            'precision',
            'symbol',
            'symbol_position',
            'decimal_mark',
            'thousands_separator',
            'enabled',
        ])->toArray();

        $currency = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->currencies()->create($fields) :
            Instrument::newCurrencyModel()->create($fields);

        event(new CurrencyCreated(user: $user, currency: $currency, data: $data));

        return $currency;
    }
}
