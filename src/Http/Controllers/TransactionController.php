<?php

namespace StarfolkSoftware\Instrument\Http\Controllers;

use StarfolkSoftware\Instrument\Contracts\CreatesTransactions;
use StarfolkSoftware\Instrument\Contracts\DeletesTransactions;
use StarfolkSoftware\Instrument\Contracts\UpdatesTransactions;
use StarfolkSoftware\Instrument\Instrument;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \StarfolkSoftware\Instrument\Contracts\CreatesTransactions  $createsTransactions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesTransactions $createsTransactions)
    {
        $account = $createsTransactions(
            request()->user(),
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['account' => $account]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $account
     * @param  \StarfolkSoftware\Instrument\Contracts\UpdatesTransactions  $updatesTransactions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($account, UpdatesTransactions $updatesTransactions)
    {
        $account = Instrument::newTransactionModel()->findOrFail($account);

        $account = $updatesTransactions(
            request()->user(),
            $account,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['account' => $account]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $account
     * @param  \StarfolkSoftware\Instrument\Contracts\DeletesTransactions  $deletesTransactions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($account, DeletesTransactions $deletesTransactions)
    {
        $account = Instrument::newTransactionModel()->findOrFail($account);

        $deletesTransactions(
            request()->user(),
            $account
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('destroy', '/'))
        );
    }
}
