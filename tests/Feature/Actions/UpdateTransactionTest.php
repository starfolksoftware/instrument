<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\UpdatesTransactions;
use StarfolkSoftware\Instrument\Events\TransactionUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingTransaction;
use StarfolkSoftware\Instrument\Tests\Mocks\Transaction;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
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
