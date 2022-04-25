<?php

namespace StarfolkSoftware\Instrument\Actions;

use StarfolkSoftware\Instrument\Contracts\DeletesAccounts;
use StarfolkSoftware\Instrument\Events\AccountDeleted;
use StarfolkSoftware\Instrument\Events\DeletingAccount;

class DeleteAccount implements DeletesAccounts
{
    /**
     * Delete a account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @return void
     */
    public function __invoke($user, $account)
    {
        event(new DeletingAccount($user, account: $account));

        $account->delete();

        event(new AccountDeleted(user: $user, account: $account));
    }
}
