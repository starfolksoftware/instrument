<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\UpdatesCurrencies;
use StarfolkSoftware\Instrument\Events\CurrencyUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingCurrency;
use StarfolkSoftware\Instrument\Tests\Mocks\Currency;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
});

it('can update an currency', function () {
    Event::fake();

    $updatesCurrencies = app(UpdatesCurrencies::class);

    $user = TestUser::first();

    $currency = Currency::factory()->create();

    $fields = currencyFields();

    $currency = $updatesCurrencies(
        $user,
        $currency,
        $fields
    );

    Event::assertDispatched(UpdatingCurrency::class);
    Event::assertDispatched(CurrencyUpdated::class);

    expect($currency->name)->toBe($fields['name']);
    expect($currency->code)->toBe($fields['code']);
});
