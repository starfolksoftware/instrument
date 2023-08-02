<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Transaction;

interface DeletesTransactions
{
    /**
     * Delete an existing transaction.
     */
    public function __invoke(Model $user, Transaction $transaction): void;
}
