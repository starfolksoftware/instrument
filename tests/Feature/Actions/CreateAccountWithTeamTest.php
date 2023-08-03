<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesAccounts;
use Instrument\Events\AccountCreated;
use Instrument\Events\CreatingAccount;
use Instrument\Instrument;
use Instrument\Tests\Mocks\Account;
use Instrument\Tests\Mocks\TeamModel;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    Instrument::supportsTeams(true);

    Instrument::useAccountModel(Account::class);

    Instrument::useTeamModel(TeamModel::class);
});

it('can create an account with team support', function () {
    Event::fake();

    $team = TeamModel::forceCreate(['name' => 'Test Team']);

    Instrument::supportsTeams();

    $createsAccounts = app(CreatesAccounts::class);

    $user = TestUser::first();

    $fields = accountFields();

    $account = $createsAccounts(
        $user,
        $fields,
        $team->id,
    );

    $account = $account->refresh();

    Event::assertDispatched(CreatingAccount::class);
    Event::assertDispatched(AccountCreated::class);

    expect($account->name)->toBe($fields['name']);
    expect($account->number)->toBe($fields['number']);

    expect($account->team)
        ->id->toBe($team->id)
        ->name->toBe('Test Team');

    expect(
        $team->refresh()->accounts()->count()
    )->toBe(1);
});
