<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Contracts\DeletesTransactions;
use Instrument\Events\DeletingTransaction;
use Instrument\Events\TransactionDeleted;
use Instrument\Transaction;

class DeleteTransaction implements DeletesTransactions
{
    /**
     * Delete a transaction.
     */
    public function __invoke(Model $user, Transaction $transaction): void
    {
        event(new DeletingTransaction($user, transaction: $transaction));

        $transaction->delete();

        event(new TransactionDeleted(user: $user, transaction: $transaction));
    }
}
