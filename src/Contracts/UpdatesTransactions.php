<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface UpdatesTransactions
{
    /**
     * Update an existing transaction.
     *
     * @param  mixed  $user
     * @param  mixed  $transaction
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $transaction, array $data);
}
