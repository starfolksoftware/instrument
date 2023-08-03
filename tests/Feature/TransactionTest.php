<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\CreatingTransaction;
use Instrument\Events\DeletingTransaction;
use Instrument\Events\TransactionCreated;
use Instrument\Events\TransactionDeleted;
use Instrument\Events\TransactionUpdated;
use Instrument\Events\UpdatingTransaction;
use Instrument\Tests\Mocks\TestUser;
use Instrument\Tests\Mocks\Transaction;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useTransactionModel(Transaction::class);
});

test('transaction can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('transactions.store'), transactionFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingTransaction::class);
    Event::assertDispatched(TransactionCreated::class);

    expect(Transaction::count())->toBe(1);
});

test('transaction can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $transaction = Transaction::factory()->create();

    $fields = transactionFields();

    $response = actingAs($user)->put(route('transactions.update', $transaction), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingTransaction::class);
    Event::assertDispatched(TransactionUpdated::class);

    $this->assertDatabaseHas('transactions', [
        'payment_method' => $fields['payment_method'],
    ]);
});

test('transaction can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $transaction = Transaction::factory()->create();

    $response = actingAs($user)->delete(route('transactions.destroy', $transaction), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingTransaction::class);
    Event::assertDispatched(TransactionDeleted::class);

    expect(Transaction::count())->toEqual(0);
});
