<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesAccounts;
use Instrument\Events\AccountUpdated;
use Instrument\Events\UpdatingAccount;
use Instrument\Tests\Mocks\Account;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
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
