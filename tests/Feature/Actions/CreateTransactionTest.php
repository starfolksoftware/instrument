<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesTransactions;
use StarfolkSoftware\Instrument\Events\TransactionCreated;
use StarfolkSoftware\Instrument\Events\CreatingTransaction;
use StarfolkSoftware\Instrument\Tests\Mocks\Transaction;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useTransactionModel(Transaction::class);
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
