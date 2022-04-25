<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesAccounts;
use StarfolkSoftware\Instrument\Events\CreatingAccount;
use StarfolkSoftware\Instrument\Events\AccountCreated;
use StarfolkSoftware\Instrument\Tests\Mocks\Account;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useAccountModel(Account::class);
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
