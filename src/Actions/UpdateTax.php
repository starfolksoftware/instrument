<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\UpdatesTaxes;
use StarfolkSoftware\Instrument\Events\TaxUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingTax;

class UpdateTax implements UpdatesTaxes
{
    /**
     * Update a tax.
     */
    public function __invoke($user, mixed $tax, array $data): mixed
    {
        event(new UpdatingTax(user: $user, tax: $tax, data: $data));

        Validator::make($data, [
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
        ])->validateWithBag('updateTax');

        $tax->update(collect($data)->only([
            'type',
            'name',
            'rate',
        ])->toArray());

        $tax->refresh();

        event(new TaxUpdated(user: $user, tax: $tax, data: $data));

        return $tax;
    }
}
