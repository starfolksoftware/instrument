<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesAccounts;
use Instrument\Events\AccountCreated;
use Instrument\Events\CreatingAccount;
use Instrument\Tests\Mocks\Account;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useAccountModel(Account::class);
});

it('can create an account', function () {
    Event::fake();

    $createsAccounts = app(CreatesAccounts::class);

    $user = TestUser::first();

    $accountFields = accountFields();

    $account = $createsAccounts(
        $user,
        $accountFields
    );

    Event::assertDispatched(CreatingAccount::class);
    Event::assertDispatched(AccountCreated::class);

    expect($account->name)->toBe($accountFields['name']);
    expect($account->number)->toBe($accountFields['number']);
});
