<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface DeletesTransactions
{
    /**
     * Delete an existing transaction.
     *
     * @param  mixed  $user
     * @param  mixed  $transaction
     * @return void
     */
    public function __invoke($user, $transaction);
}
