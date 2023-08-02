<?php

namespace StarfolkSoftware\Instrument\Contracts;

use StarfolkSoftware\Instrument\Tax;

interface UpdatesTaxes
{
    /**
     * Update an existing tax.
     */
    public function __invoke(mixed $user, mixed $tax, array $data): mixed;
}