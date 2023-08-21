<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesPaymentMethods;
use Instrument\Events\PaymentMethodCreated;
use Instrument\Events\CreatingPaymentMethod;
use Instrument\Tests\Mocks\PaymentMethod;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::usePaymentMethodModel(PaymentMethod::class);
});

it('can create a payment method', function () {
    Event::fake();

    $createsPaymentMethods = app(CreatesPaymentMethods::class);

    $user = TestUser::first();

    $paymentMethodFields = paymentMethodFields();

    $paymentMethod = $createsPaymentMethods(
        $user,
        $paymentMethodFields
    );

    Event::assertDispatched(CreatingPaymentMethod::class);
    Event::assertDispatched(PaymentMethodCreated::class);

    expect($paymentMethod->name)->toBe($paymentMethodFields['name']);
});
