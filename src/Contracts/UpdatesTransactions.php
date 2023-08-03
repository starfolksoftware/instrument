<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Transaction;

interface UpdatesTransactions
{
    /**
     * Update an existing transaction.
     */
    public function __invoke(Model $user, Transaction $transaction, array $data): Transaction;
}
