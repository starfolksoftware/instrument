<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\PaymentMethodCreated;
use Instrument\Events\PaymentMethodDeleted;
use Instrument\Events\PaymentMethodUpdated;
use Instrument\Events\CreatingPaymentMethod;
use Instrument\Events\DeletingPaymentMethod;
use Instrument\Events\UpdatingPaymentMethod;
use Instrument\Tests\Mocks\PaymentMethod;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::usePaymentMethodModel(PaymentMethod::class);
});

test('payment method can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('payment-methods.store'), paymentMethodFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingPaymentMethod::class);
    Event::assertDispatched(PaymentMethodCreated::class);

    expect(PaymentMethod::count())->toBe(1);
});

test('payment method can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $paymentMethod = PaymentMethod::factory()->create();

    $fields = paymentMethodFields();

    $response = actingAs($user)->put(route('payment-methods.update', $paymentMethod), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingPaymentMethod::class);
    Event::assertDispatched(PaymentMethodUpdated::class);

    $this->assertDatabaseHas('payment_methods', [
        'name' => $fields['name'],
    ]);
});

test('payment method can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $paymentMethod = PaymentMethod::factory()->create();

    $response = actingAs($user)->delete(route('payment-methods.destroy', $paymentMethod), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingPaymentMethod::class);
    Event::assertDispatched(PaymentMethodDeleted::class);

    expect(PaymentMethod::count())->toEqual(0);
});
