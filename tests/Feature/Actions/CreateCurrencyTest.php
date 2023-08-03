<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesCurrencies;
use Instrument\Events\CreatingCurrency;
use Instrument\Events\CurrencyCreated;
use Instrument\Tests\Mocks\Currency;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useCurrencyModel(Currency::class);
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
