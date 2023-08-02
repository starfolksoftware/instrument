<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Contracts\DeletesTaxes;
use StarfolkSoftware\Instrument\Events\DeletingTax;
use StarfolkSoftware\Instrument\Events\TaxDeleted;
use StarfolkSoftware\Instrument\Tax;

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
