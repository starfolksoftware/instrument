<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Transaction;

interface CreatesTransactions
{
    /**
     * Create a new transaction.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Transaction;
}
