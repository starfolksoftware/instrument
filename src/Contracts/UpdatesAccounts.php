<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Account;

interface UpdatesAccounts
{
    /**
     * Update an existing account.
     */
    public function __invoke(Model $user, Account $account, array $data): Account;
}
