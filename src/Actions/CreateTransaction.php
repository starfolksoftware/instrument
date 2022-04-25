<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\CreatesTransactions;
use StarfolkSoftware\Instrument\Events\TransactionCreated;
use StarfolkSoftware\Instrument\Events\CreatingTransaction;
use StarfolkSoftware\Instrument\Instrument;

class CreateTransaction implements CreatesTransactions
{
    /**
     * Create a new transaction.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return mixed
     */
    public function __invoke($user, array $data, $teamId = null)
    {
        event(new CreatingTransaction(user: $user, data: $data));

        Validator::make($data, [
            'account_id' => 'nullable|exists:accounts,id',
            'document_id' => 'nullable|exists:documents,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'paid_at' => 'required|date:Y-m-d',
            'meta' => 'nullable|array',
        ])->validateWithBag('createTransaction');

        $fields = collect($data)->only([
            'account_id',
            'document_id',
            'amount',
            'payment_method',
            'paid_at',
            'meta',
        ])->toArray();

        $transaction = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->transactions()->create($fields) :
            Instrument::newTransactionModel()->create($fields);

        event(new TransactionCreated(transaction: $transaction));

        return $transaction;
    }
}
