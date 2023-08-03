<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Account;
use Instrument\Contracts\CreatesAccounts;
use Instrument\Events\AccountCreated;
use Instrument\Events\CreatingAccount;
use Instrument\Instrument;

class CreateAccount implements CreatesAccounts
{
    /**
     * Create a new account.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Account
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
