<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Account;

interface DeletesAccounts
{
    /**
     * Delete an existing account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @return void
     */
    public function __invoke(Model $user, Account $account): void;
}
