<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Events\TransactionCreated;
use StarfolkSoftware\Instrument\Events\TransactionDeleted;
use StarfolkSoftware\Instrument\Events\TransactionUpdated;
use StarfolkSoftware\Instrument\Events\CreatingTransaction;
use StarfolkSoftware\Instrument\Events\DeletingTransaction;
use StarfolkSoftware\Instrument\Events\UpdatingTransaction;
use StarfolkSoftware\Instrument\Tests\Mocks\Transaction;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useTransactionModel(Transaction::class);
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
