<?php

namespace Instrument\Http\Controllers;

use Instrument\Contracts\CreatesTransactions;
use Instrument\Contracts\DeletesTransactions;
use Instrument\Contracts\UpdatesTransactions;
use Instrument\Instrument;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Instrument\Contracts\CreatesTransactions  $createsTransactions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesTransactions $createsTransactions)
    {
        $account = $createsTransactions(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['account' => $account]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('transactions', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $account
     * @param  \Instrument\Contracts\UpdatesTransactions  $updatesTransactions
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
            request()->get('redirect', Instrument::redirects('transactions', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $account
     * @param  \Instrument\Contracts\DeletesTransactions  $deletesTransactions
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
            request()->get('redirect', Instrument::redirects('transactions', 'destroy', '/'))
        );
    }
}
