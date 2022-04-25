<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\CreatesAccounts;
use StarfolkSoftware\Instrument\Events\AccountCreated;
use StarfolkSoftware\Instrument\Events\CreatingAccount;
use StarfolkSoftware\Instrument\Instrument;

class CreateAccount implements CreatesAccounts
{
    /**
     * Create a new account.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return mixed
     */
    public function __invoke($user, array $data, $teamId = null)
    {
        event(new CreatingAccount(user: $user, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'opening_balance' => 'required|numeric',
            'meta' => 'nullable|array',
        ])->validateWithBag('createAccount');

        $fields = collect($data)->only([
            'name',
            'number',
            'opening_balance',
            'meta',
        ])->toArray();

        $account = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->accounts()->create($fields) :
            Instrument::newAccountModel()->create($fields);

        event(new AccountCreated(account: $account));

        return $account;
    }
}
