<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesCurrencies;
use Instrument\Events\CurrencyUpdated;
use Instrument\Events\UpdatingCurrency;
use Instrument\Tests\Mocks\Currency;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
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
