<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesPaymentMethods;
use Instrument\Events\DeletingPaymentMethod;
use Instrument\Events\PaymentMethodDeleted;
use Instrument\Tests\Mocks\PaymentMethod;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::usePaymentMethodModel(PaymentMethod::class);
});

it('can delete a payment method', function () {
    Event::fake();

    $deletesPaymentMethods = app(DeletesPaymentMethods::class);

    $user = TestUser::first();

    $paymentMethod = PaymentMethod::factory()->create();

    $deletesPaymentMethods($user, $paymentMethod);

    Event::assertDispatched(DeletingPaymentMethod::class);
    Event::assertDispatched(PaymentMethodDeleted::class);

    expect(PaymentMethod::count())->toEqual(0);
});
