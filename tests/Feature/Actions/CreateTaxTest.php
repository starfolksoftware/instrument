<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesTaxes;
use StarfolkSoftware\Instrument\Events\CreatingTax;
use StarfolkSoftware\Instrument\Events\TaxCreated;
use StarfolkSoftware\Instrument\Tests\Mocks\Tax;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useTaxModel(Tax::class);
});

it('can create an tax', function () {
    Event::fake();

    $createsTaxes = app(CreatesTaxes::class);

    $user = TestUser::first();

    $taxFields = taxFields();

    $tax = $createsTaxes(
        $user,
        $taxFields
    );

    Event::assertDispatched(CreatingTax::class);
    Event::assertDispatched(TaxCreated::class);

    expect($tax->name)->toBe($taxFields['name']);
    expect($tax->type)->toBe($taxFields['type']);
});
