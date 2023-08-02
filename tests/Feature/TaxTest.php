<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Events\CreatingTax;
use StarfolkSoftware\Instrument\Events\DeletingTax;
use StarfolkSoftware\Instrument\Events\TaxCreated;
use StarfolkSoftware\Instrument\Events\TaxDeleted;
use StarfolkSoftware\Instrument\Events\TaxUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingTax;
use StarfolkSoftware\Instrument\Tests\Mocks\Tax;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useTaxModel(Tax::class);
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
