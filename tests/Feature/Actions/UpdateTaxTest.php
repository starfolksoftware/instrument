<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\UpdatesTaxes;
use StarfolkSoftware\Instrument\Events\TaxUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingTax;
use StarfolkSoftware\Instrument\Tests\Mocks\Tax;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
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
