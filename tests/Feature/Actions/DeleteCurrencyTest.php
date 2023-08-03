<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesCurrencies;
use Instrument\Events\CurrencyDeleted;
use Instrument\Events\DeletingCurrency;
use Instrument\Tests\Mocks\Currency;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useCurrencyModel(Currency::class);
});

it('can delete an currency', function () {
    Event::fake();

    $deletesCurrencies = app(DeletesCurrencies::class);

    $user = TestUser::first();

    $currency = Currency::factory()->create();

    $deletesCurrencies($user, $currency);

    Event::assertDispatched(DeletingCurrency::class);
    Event::assertDispatched(CurrencyDeleted::class);

    expect(Currency::count())->toEqual(0);
});
