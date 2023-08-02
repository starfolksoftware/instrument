<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Account;

interface CreatesAccounts
{
    /**
     * Create a new account.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Account;
}
