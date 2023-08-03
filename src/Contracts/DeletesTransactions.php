<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Transaction;

interface DeletesTransactions
{
    /**
     * Delete an existing transaction.
     */
    public function __invoke(Model $user, Transaction $transaction): void;
}
