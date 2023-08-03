<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesTransactions;
use Instrument\Events\TransactionUpdated;
use Instrument\Events\UpdatingTransaction;
use Instrument\Tests\Mocks\TestUser;
use Instrument\Tests\Mocks\Transaction;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
});

it('can update an transaction', function () {
    Event::fake();

    $updatesTransactions = app(UpdatesTransactions::class);

    $user = TestUser::first();

    $transaction = Transaction::factory()->create();

    $fields = transactionFields();

    $transaction = $updatesTransactions(
        $user,
        $transaction,
        $fields
    );

    Event::assertDispatched(UpdatingTransaction::class);
    Event::assertDispatched(TransactionUpdated::class);

    expect($transaction->payment_method)->toBe($fields['payment_method']);
});
