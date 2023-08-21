<?php

namespace Instrument;

use Illuminate\Database\Eloquent\Model;

abstract class PaymentMethod extends Model
{
    /**
     * The team that owns the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Instrument::teamModel(), 'team_id');
    }

    /**
     * The transactions that belong to the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Instrument::transactionModel(), 'payment_method_id');
    }
}
