<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesTransactions;
use Instrument\Events\DeletingTransaction;
use Instrument\Events\TransactionDeleted;
use Instrument\Tests\Mocks\TestUser;
use Instrument\Tests\Mocks\Transaction;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useTransactionModel(Transaction::class);
});

it('can delete an transaction', function () {
    Event::fake();

    $deletesTransactions = app(DeletesTransactions::class);

    $user = TestUser::first();

    $transaction = Transaction::factory()->create();

    $deletesTransactions($user, $transaction);

    Event::assertDispatched(DeletingTransaction::class);
    Event::assertDispatched(TransactionDeleted::class);

    expect(Transaction::count())->toEqual(0);
});
