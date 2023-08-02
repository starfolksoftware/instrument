<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\CreatesTaxes;
use StarfolkSoftware\Instrument\Events\CreatingTax;
use StarfolkSoftware\Instrument\Events\TaxCreated;
use StarfolkSoftware\Instrument\Instrument;
use StarfolkSoftware\Instrument\Tax;

class CreateTax implements CreatesTaxes
{
    /**
     * Create a new tax.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Tax
    {
        event(new CreatingTax(user: $user, data: $data));

        Validator::make($data, [
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric',
        ])->validateWithBag('createTax');

        $fields = collect($data)->only([
            'type',
            'name',
            'rate',
        ])->toArray();

        $tax = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->taxes()->create($fields) :
            Instrument::newTaxModel()->create($fields);

        event(new TaxCreated(user: $user, tax: $tax, data: $data));

        return $tax;
    }
}