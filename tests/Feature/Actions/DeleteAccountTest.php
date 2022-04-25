<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\DeletesAccounts;
use StarfolkSoftware\Instrument\Events\DeletingAccount;
use StarfolkSoftware\Instrument\Events\AccountDeleted;
use StarfolkSoftware\Instrument\Tests\Mocks\Account;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
    \StarfolkSoftware\Instrument\Instrument::useAccountModel(Account::class);
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
