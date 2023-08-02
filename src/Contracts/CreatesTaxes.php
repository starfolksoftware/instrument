<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Tax;

interface CreatesTaxes
{
    /**
     * Create a new tax.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Tax;
}
