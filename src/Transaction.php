<?php

namespace StarfolkSoftware\Instrument;

use Illuminate\Database\Eloquent\Model;

abstract class Transaction extends Model
{
    /**
     * The team that owns the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Instrument::$teamModel, 'team_id');
    }

    /**
     * The account that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Instrument::$accountModel, 'account_id');
    }

    /**
     * The document that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document()
    {
        return $this->belongsTo(Instrument::$documentModel, 'document_id');
    }

    /**
     * Scope a query to only include transactions for the given payment method.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $paymentMethod
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPaymentMethod($query, $paymentMethod)
    {
        return $query->where('payment_method', $paymentMethod);
    }
}
