<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface DeletesTaxes
{
    /**
     * Delete an existing tax.
     */
    public function __invoke(mixed $user, mixed $tax): void;
}
