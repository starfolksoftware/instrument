<?php

namespace StarfolkSoftware\Instrument\Http\Controllers;

use StarfolkSoftware\Instrument\Contracts\CreatesAccounts;
use StarfolkSoftware\Instrument\Contracts\DeletesAccounts;
use StarfolkSoftware\Instrument\Contracts\UpdatesAccounts;
use StarfolkSoftware\Instrument\Instrument;

class AccountController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \StarfolkSoftware\Instrument\Contracts\CreatesAccounts  $createsAccounts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesAccounts $createsAccounts)
    {
        $account = $createsAccounts(
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
     * @param  \StarfolkSoftware\Instrument\Contracts\UpdatesAccounts  $updatesAccounts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($account, UpdatesAccounts $updatesAccounts)
    {
        $account = Instrument::newAccountModel()->findOrFail($account);

        $account = $updatesAccounts(
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
     * @param  \StarfolkSoftware\Instrument\Contracts\DeletesAccounts  $deletesAccounts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($account, DeletesAccounts $deletesAccounts)
    {
        $account = Instrument::newAccountModel()->findOrFail($account);

        $deletesAccounts(
            request()->user(),
            $account
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('destroy', '/'))
        );
    }
}
