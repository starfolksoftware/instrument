<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Transaction;

interface CreatesTransactions
{
    /**
     * Create a new transaction.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Transaction;
}
