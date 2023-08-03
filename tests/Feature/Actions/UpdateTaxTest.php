<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesTaxes;
use Instrument\Events\TaxUpdated;
use Instrument\Events\UpdatingTax;
use Instrument\Tests\Mocks\Tax;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
});

it('can update an tax', function () {
    Event::fake();

    $updatesTaxes = app(UpdatesTaxes::class);

    $user = TestUser::first();

    $tax = Tax::factory()->create();

    $fields = taxFields();

    $tax = $updatesTaxes(
        $user,
        $tax,
        $fields
    );

    Event::assertDispatched(UpdatingTax::class);
    Event::assertDispatched(TaxUpdated::class);

    expect($tax->name)->toBe($fields['name']);
    expect($tax->type)->toBe($fields['type']);
});
