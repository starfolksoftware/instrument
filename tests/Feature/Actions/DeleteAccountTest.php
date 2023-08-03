<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesAccounts;
use Instrument\Events\AccountDeleted;
use Instrument\Events\DeletingAccount;
use Instrument\Tests\Mocks\Account;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useAccountModel(Account::class);
});

it('can delete an account', function () {
    Event::fake();

    $deletesAccounts = app(DeletesAccounts::class);

    $user = TestUser::first();

    $account = Account::factory()->create();

    $deletesAccounts($user, $account);

    Event::assertDispatched(DeletingAccount::class);
    Event::assertDispatched(AccountDeleted::class);

    expect(Account::count())->toEqual(0);
});
