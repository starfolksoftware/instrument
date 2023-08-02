<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\DeletesCurrencies;
use StarfolkSoftware\Instrument\Events\DeletingCurrency;
use StarfolkSoftware\Instrument\Events\CurrencyDeleted;
use StarfolkSoftware\Instrument\Tests\Mocks\Currency;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
    \StarfolkSoftware\Instrument\Instrument::useCurrencyModel(Currency::class);
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
