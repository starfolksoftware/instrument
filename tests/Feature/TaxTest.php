<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\CreatingTax;
use Instrument\Events\DeletingTax;
use Instrument\Events\TaxCreated;
use Instrument\Events\TaxDeleted;
use Instrument\Events\TaxUpdated;
use Instrument\Events\UpdatingTax;
use Instrument\Tests\Mocks\Tax;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useTaxModel(Tax::class);
});

test('tax can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('taxes.store'), taxFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingTax::class);
    Event::assertDispatched(TaxCreated::class);

    expect(Tax::count())->toBe(1);
});

test('tax can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $tax = Tax::factory()->create();

    $fields = taxFields();

    $response = actingAs($user)->put(route('taxes.update', $tax), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingTax::class);
    Event::assertDispatched(TaxUpdated::class);

    $this->assertDatabaseHas('taxes', [
        'name' => $fields['name'],
        'type' => $fields['type'],
    ]);
});

test('tax can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $tax = Tax::factory()->create();

    $response = actingAs($user)->delete(route('taxes.destroy', $tax), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingTax::class);
    Event::assertDispatched(TaxDeleted::class);

    expect(Tax::count())->toEqual(0);
});
