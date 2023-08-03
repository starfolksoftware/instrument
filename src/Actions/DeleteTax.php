<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Contracts\DeletesTaxes;
use Instrument\Events\DeletingTax;
use Instrument\Events\TaxDeleted;
use Instrument\Tax;

class DeleteTax implements DeletesTaxes
{
    /**
     * Delete a tax.
     */
    public function __invoke(Model $user, Tax $tax): void
    {
        event(new DeletingTax(user: $user, tax: $tax));

        $tax->delete();

        event(new TaxDeleted(user: $user, tax: $tax));
    }
}
