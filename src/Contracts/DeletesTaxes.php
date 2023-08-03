<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Tax;

interface DeletesTaxes
{
    /**
     * Delete an existing tax.
     */
    public function __invoke(Model $user, Tax $tax): void;
}
