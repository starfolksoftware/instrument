<?php

namespace Instrument\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Instrument\Contracts\CreatesCurrencies;
use Instrument\Contracts\DeletesCurrencies;
use Instrument\Contracts\UpdatesCurrencies;
use Instrument\Instrument;

class CurrencyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatesCurrencies $createsCurrencies): RedirectResponse|JsonResponse
    {
        $currency = $createsCurrencies(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['currency' => $currency]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('currencies', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(mixed $currency, UpdatesCurrencies $updatesCurrencies): RedirectResponse|JsonResponse
    {
        $currency = Instrument::newCurrencyModel()->findOrFail($currency);

        $currency = $updatesCurrencies(
            request()->user(),
            $currency,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['currency' => $currency]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('currencies', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(mixed $currency, DeletesCurrencies $deletesCurrencies): RedirectResponse|JsonResponse
    {
        $currency = Instrument::newCurrencyModel()->findOrFail($currency);

        $deletesCurrencies(
            request()->user(),
            $currency
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('currencies', 'destroy', '/'))
        );
    }
}
