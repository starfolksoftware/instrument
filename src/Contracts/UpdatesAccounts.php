<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface UpdatesAccounts
{
    /**
     * Update an existing account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $account, array $data);
}
