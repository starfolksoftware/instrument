<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\UpdatesTransactions;
use StarfolkSoftware\Instrument\Events\TransactionUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingTransaction;
use StarfolkSoftware\Instrument\Transaction;

class UpdateTransaction implements UpdatesTransactions
{
    /**
     * Update an existing transaction.
     */
    public function __invoke(Model $user, Transaction $transaction, array $data): Transaction
    {
        event(new UpdatingTransaction(user: $user, transaction: $transaction, data: $data));

        Validator::make($data, [
            'account_id' => 'nullable|exists:accounts,id',
            'document_id' => 'nullable|exists:documents,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'paid_at' => 'required|date:Y-m-d',
            'meta' => 'nullable|array',
        ])->validateWithBag('updateTransaction');

        $transaction->update(collect($data)->only([
            'account_id',
            'document_id',
            'amount',
            'payment_method',
            'paid_at',
            'meta',
        ])->toArray());

        event(new TransactionUpdated(user: $user, transaction: $transaction));

        return $transaction->refresh();
    }
}
