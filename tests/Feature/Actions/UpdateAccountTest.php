<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\UpdatesAccounts;
use StarfolkSoftware\Instrument\Events\AccountUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingAccount;
use StarfolkSoftware\Instrument\Tests\Mocks\Account;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
});

it('can update an account', function () {
    Event::fake();

    $updatesAccounts = app(UpdatesAccounts::class);

    $user = TestUser::first();

    $account = Account::factory()->create();

    $fields = accountFields();

    $account = $updatesAccounts(
        $user,
        $account,
        $fields
    );

    Event::assertDispatched(UpdatingAccount::class);
    Event::assertDispatched(AccountUpdated::class);

    expect($account->name)->toBe($fields['name']);
    expect($account->number)->toBe($fields['number']);
});
