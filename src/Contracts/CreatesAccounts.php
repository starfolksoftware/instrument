<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface CreatesAccounts
{
    /**
     * Create a new account.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return mixed
     */
    public function __invoke($user, array $data, $teamId = null);
}
