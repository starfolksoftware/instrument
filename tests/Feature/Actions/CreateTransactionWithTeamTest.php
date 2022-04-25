<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesTransactions;
use StarfolkSoftware\Instrument\Events\CreatingTransaction;
use StarfolkSoftware\Instrument\Events\TransactionCreated;
use StarfolkSoftware\Instrument\Instrument;
use StarfolkSoftware\Instrument\Tests\Mocks\TeamModel;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;
use StarfolkSoftware\Instrument\Tests\Mocks\Transaction;

beforeAll(function () {
    Instrument::supportsTeams(true);

    Instrument::useTransactionModel(Transaction::class);

    Instrument::useTeamModel(TeamModel::class);
});

it('can create an transaction with team support', function () {
    Event::fake();

    $team = TeamModel::forceCreate(['name' => 'Test Team']);

    Instrument::supportsTeams();

    $createsTransactions = app(CreatesTransactions::class);

    $user = TestUser::first();

    $fields = transactionFields();

    $transaction = $createsTransactions(
        $user,
        $fields,
        $team->id,
    );

    $transaction = $transaction->refresh();

    Event::assertDispatched(CreatingTransaction::class);
    Event::assertDispatched(TransactionCreated::class);

    expect($transaction->payment_method)->toBe($fields['payment_method']);

    expect($transaction->team)
        ->id->toBe($team->id)
        ->name->toBe('Test Team');

    expect(
        $team->refresh()->transactions()->count()
    )->toBe(1);
});
