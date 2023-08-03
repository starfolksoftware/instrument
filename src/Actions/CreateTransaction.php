<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Contracts\CreatesTransactions;
use Instrument\Events\CreatingTransaction;
use Instrument\Events\TransactionCreated;
use Instrument\Instrument;
use Instrument\Transaction;

class CreateTransaction implements CreatesTransactions
{
    /**
     * Create a new transaction.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Transaction
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
