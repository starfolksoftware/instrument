<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesPaymentMethods;
use Instrument\Events\PaymentMethodUpdated;
use Instrument\Events\UpdatingPaymentMethod;
use Instrument\Tests\Mocks\PaymentMethod;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
});

it('can update an payment method', function () {
    Event::fake();

    $updatesPaymentMethods = app(UpdatesPaymentMethods::class);

    $user = TestUser::first();

    $paymentMethod = PaymentMethod::factory()->create();

    $fields = paymentMethodFields();

    $paymentMethod = $updatesPaymentMethods(
        $user,
        $paymentMethod,
        $fields
    );

    Event::assertDispatched(UpdatingPaymentMethod::class);
    Event::assertDispatched(PaymentMethodUpdated::class);

    expect($paymentMethod->name)->toBe($fields['name']);
});
