<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\CreatingCurrency;
use Instrument\Events\CurrencyCreated;
use Instrument\Events\CurrencyDeleted;
use Instrument\Events\CurrencyUpdated;
use Instrument\Events\DeletingCurrency;
use Instrument\Events\UpdatingCurrency;
use Instrument\Tests\Mocks\Currency;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useCurrencyModel(Currency::class);
});

test('currency can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('currencies.store'), currencyFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingCurrency::class);
    Event::assertDispatched(CurrencyCreated::class);

    expect(Currency::count())->toBe(1);
});

test('currency can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $currency = Currency::factory()->create();

    $fields = currencyFields();

    $response = actingAs($user)->put(route('currencies.update', $currency), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingCurrency::class);
    Event::assertDispatched(CurrencyUpdated::class);

    $this->assertDatabaseHas('currencies', [
        'name' => $fields['name'],
        'code' => $fields['code'],
    ]);
});

test('currency can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $currency = Currency::factory()->create();

    $response = actingAs($user)->delete(route('currencies.destroy', $currency), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingCurrency::class);
    Event::assertDispatched(CurrencyDeleted::class);

    expect(Currency::count())->toEqual(0);
});
