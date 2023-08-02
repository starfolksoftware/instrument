<?php

namespace StarfolkSoftware\Instrument\Actions;

use StarfolkSoftware\Instrument\Contracts\DeletesTaxes;
use StarfolkSoftware\Instrument\Events\DeletingTax;
use StarfolkSoftware\Instrument\Events\TaxDeleted;

class DeleteTax implements DeletesTaxes
{
    /**
     * Delete a tax.
     */
    public function __invoke($user, mixed $tax): void
    {
        event(new DeletingTax(user: $user, tax: $tax));

        $tax->delete();

        event(new TaxDeleted(user: $user, tax: $tax));
    }
}
