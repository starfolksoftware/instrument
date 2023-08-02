<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface CreatesTaxes
{
    /**
     * Create a new tax.
     */
    public function __invoke(mixed $user, array $data, $teamId = null): mixed;
}