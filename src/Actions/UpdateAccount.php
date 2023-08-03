<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Account;
use Instrument\Contracts\UpdatesAccounts;
use Instrument\Events\AccountUpdated;
use Instrument\Events\UpdatingAccount;

class UpdateAccount implements UpdatesAccounts
{
    /**
     * Update an existing account.
     */
    public function __invoke(Model $user, Account $account, array $data): Account
    {
        event(new UpdatingAccount(user: $user, account: $account, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'opening_balance' => 'required|numeric',
            'meta' => 'nullable|array',
        ])->validateWithBag('updateAccount');

        $account->update(collect($data)->only([
            'name',
            'number',
            'opening_balance',
            'meta',
        ])->toArray());

        event(new AccountUpdated(user: $user, account: $account));

        return $account->refresh();
    }
}
