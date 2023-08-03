<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Account;

interface CreatesAccounts
{
    /**
     * Create a new account.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Account;
}
