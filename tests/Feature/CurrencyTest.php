<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Events\CreatingCurrency;
use StarfolkSoftware\Instrument\Events\CurrencyCreated;
use StarfolkSoftware\Instrument\Events\CurrencyDeleted;
use StarfolkSoftware\Instrument\Events\CurrencyUpdated;
use StarfolkSoftware\Instrument\Events\DeletingCurrency;
use StarfolkSoftware\Instrument\Events\UpdatingCurrency;
use StarfolkSoftware\Instrument\Tests\Mocks\Currency;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useCurrencyModel(Currency::class);
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
