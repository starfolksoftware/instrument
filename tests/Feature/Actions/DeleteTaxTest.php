<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\DeletesTaxes;
use StarfolkSoftware\Instrument\Events\DeletingTax;
use StarfolkSoftware\Instrument\Events\TaxDeleted;
use StarfolkSoftware\Instrument\Tests\Mocks\Tax;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
    \StarfolkSoftware\Instrument\Instrument::useTaxModel(Tax::class);
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
