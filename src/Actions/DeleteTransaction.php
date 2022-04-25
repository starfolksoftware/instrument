<?php

namespace StarfolkSoftware\Instrument\Actions;

use StarfolkSoftware\Instrument\Contracts\DeletesTransactions;
use StarfolkSoftware\Instrument\Events\DeletingTransaction;
use StarfolkSoftware\Instrument\Events\TransactionDeleted;

class DeleteTransaction implements DeletesTransactions
{
    /**
     * Delete a transaction.
     *
     * @param  mixed  $user
     * @param  mixed  $transaction
     * @return void
     */
    public function __invoke($user, $transaction)
    {
        event(new DeletingTransaction($user, transaction: $transaction));

        $transaction->delete();

        event(new TransactionDeleted(user: $user, transaction: $transaction));
    }
}
