<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Tax;

interface CreatesTaxes
{
    /**
     * Create a new tax.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Tax;
}
