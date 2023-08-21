<?php

namespace Instrument\Http\Controllers;

use Instrument\Contracts\CreatesPaymentMethods;
use Instrument\Contracts\DeletesPaymentMethods;
use Instrument\Contracts\UpdatesPaymentMethods;
use Instrument\Instrument;

class PaymentMethodController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Instrument\Contracts\CreatesPaymentMethods  $createsPaymentMethods
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesPaymentMethods $createsPaymentMethods)
    {
        $account = $createsPaymentMethods(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['account' => $account]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('accounts', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $account
     * @param  \Instrument\Contracts\UpdatesPaymentMethods  $updatesPaymentMethods
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($account, UpdatesPaymentMethods $updatesPaymentMethods)
    {
        $account = Instrument::newPaymentMethodModel()->findOrFail($account);

        $account = $updatesPaymentMethods(
            request()->user(),
            $account,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['account' => $account]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('accounts', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $account
     * @param  \Instrument\Contracts\DeletesPaymentMethods  $deletesPaymentMethods
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($account, DeletesPaymentMethods $deletesPaymentMethods)
    {
        $account = Instrument::newPaymentMethodModel()->findOrFail($account);

        $deletesPaymentMethods(
            request()->user(),
            $account
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('accounts', 'destroy', '/'))
        );
    }
}
