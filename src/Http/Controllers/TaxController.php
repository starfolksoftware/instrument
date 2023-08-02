<?php

namespace StarfolkSoftware\Instrument\Http\Controllers;

use StarfolkSoftware\Instrument\Contracts\CreatesTaxes;
use StarfolkSoftware\Instrument\Contracts\DeletesTaxes;
use StarfolkSoftware\Instrument\Contracts\UpdatesTaxes;
use StarfolkSoftware\Instrument\Instrument;

class TaxController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \StarfolkSoftware\Instrument\Contracts\CreatesTaxes  $createsTaxes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesTaxes $createsTaxes)
    {
        $tax = $createsTaxes(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['tax' => $tax]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('taxes', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $tax
     * @param  \StarfolkSoftware\Instrument\Contracts\UpdatesTaxes  $updatesTaxes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(mixed $tax, UpdatesTaxes $updatesTaxes)
    {
        $tax = Instrument::newTaxModel()->findOrFail($tax);

        $tax = $updatesTaxes(
            request()->user(),
            $tax,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['tax' => $tax]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('taxes', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $tax
     * @param  \StarfolkSoftware\Instrument\Contracts\DeletesTaxes  $deletesTaxes
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(mixed $tax, DeletesTaxes $deletesTaxes)
    {
        $tax = Instrument::newTaxModel()->findOrFail($tax);
        
        $deletesTaxes(
            request()->user(),
            $tax
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('taxes', 'destroy', '/'))
        );
    }
}