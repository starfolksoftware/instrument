<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\DeletesTransactions;
use StarfolkSoftware\Instrument\Events\DeletingTransaction;
use StarfolkSoftware\Instrument\Events\TransactionDeleted;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;
use StarfolkSoftware\Instrument\Tests\Mocks\Transaction;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
    \StarfolkSoftware\Instrument\Instrument::useTransactionModel(Transaction::class);
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
