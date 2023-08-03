<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesTaxes;
use Instrument\Events\CreatingTax;
use Instrument\Events\TaxCreated;
use Instrument\Tests\Mocks\Tax;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useTaxModel(Tax::class);
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
