<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Tax;

interface UpdatesTaxes
{
    /**
     * Update an existing tax.
     */
    public function __invoke(Model $user, Tax $tax, array $data): Tax;
}
