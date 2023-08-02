<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Account;
use StarfolkSoftware\Instrument\Contracts\DeletesAccounts;
use StarfolkSoftware\Instrument\Events\AccountDeleted;
use StarfolkSoftware\Instrument\Events\DeletingAccount;

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
