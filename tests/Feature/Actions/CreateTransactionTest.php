<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesTransactions;
use Instrument\Events\CreatingTransaction;
use Instrument\Events\TransactionCreated;
use Instrument\Tests\Mocks\TestUser;
use Instrument\Tests\Mocks\Transaction;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useTransactionModel(Transaction::class);
});

it('can create an transaction', function () {
    Event::fake();

    $createsTransactions = app(CreatesTransactions::class);

    $user = TestUser::first();

    $transactionFields = transactionFields();

    $transaction = $createsTransactions(
        $user,
        $transactionFields
    );

    Event::assertDispatched(CreatingTransaction::class);
    Event::assertDispatched(TransactionCreated::class);

    expect($transaction->payment_method)->toBe($transactionFields['payment_method']);
});
