<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface CreatesTransactions
{
    /**
     * Create a new transaction.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return mixed
     */
    public function __invoke($user, array $data, $teamId = null);
}
