<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\UpdatesTransactions;
use StarfolkSoftware\Instrument\Events\TransactionUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingTransaction;

class UpdateTransaction implements UpdatesTransactions
{
    /**
     * Update an existing transaction.
     *
     * @param  mixed  $user
     * @param  mixed  $transaction
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $transaction, array $data)
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
