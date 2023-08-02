<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesCurrencies;
use StarfolkSoftware\Instrument\Events\CreatingCurrency;
use StarfolkSoftware\Instrument\Events\CurrencyCreated;
use StarfolkSoftware\Instrument\Tests\Mocks\Currency;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useCurrencyModel(Currency::class);
});

it('can create an currency', function () {
    Event::fake();

    $createsCurrencies = app(CreatesCurrencies::class);

    $user = TestUser::first();

    $currencyFields = currencyFields();

    $currency = $createsCurrencies(
        $user,
        $currencyFields
    );

    Event::assertDispatched(CreatingCurrency::class);
    Event::assertDispatched(CurrencyCreated::class);

    expect($currency->name)->toBe($currencyFields['name']);
    expect($currency->code)->toBe($currencyFields['code']);
});
