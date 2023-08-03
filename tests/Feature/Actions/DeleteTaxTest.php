<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesTaxes;
use Instrument\Events\DeletingTax;
use Instrument\Events\TaxDeleted;
use Instrument\Tests\Mocks\Tax;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useTaxModel(Tax::class);
});

it('can delete an tax', function () {
    Event::fake();

    $deletesTaxes = app(DeletesTaxes::class);

    $user = TestUser::first();

    $tax = Tax::factory()->create();

    $deletesTaxes($user, $tax);

    Event::assertDispatched(DeletingTax::class);
    Event::assertDispatched(TaxDeleted::class);

    expect(Tax::count())->toEqual(0);
});
