<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Contracts\UpdatesTaxes;
use Instrument\Events\TaxUpdated;
use Instrument\Events\UpdatingTax;
use Instrument\Tax;

class UpdateTax implements UpdatesTaxes
{
    /**
     * Update a tax.
     */
    public function __invoke(Model $user, Tax $tax, array $data): Tax
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
