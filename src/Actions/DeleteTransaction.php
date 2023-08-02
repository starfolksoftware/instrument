<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Contracts\DeletesTransactions;
use StarfolkSoftware\Instrument\Events\DeletingTransaction;
use StarfolkSoftware\Instrument\Events\TransactionDeleted;
use StarfolkSoftware\Instrument\Transaction;

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
