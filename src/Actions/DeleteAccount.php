<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Account;
use Instrument\Contracts\DeletesAccounts;
use Instrument\Events\AccountDeleted;
use Instrument\Events\DeletingAccount;

class DeleteAccount implements DeletesAccounts
{
    /**
     * Delete a account.
     */
    public function __invoke(Model $user, Account $account): void
    {
        event(new DeletingAccount($user, account: $account));

        $account->delete();

        event(new AccountDeleted(user: $user, account: $account));
    }
}
