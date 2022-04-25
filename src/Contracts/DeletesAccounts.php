<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface DeletesAccounts
{
    /**
     * Delete an existing account.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @return void
     */
    public function __invoke($user, $account);
}
