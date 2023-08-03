<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Instrument\Transaction as InstrumentTransaction;
use Instrument\Events\TransactionCreated;
use Instrument\Events\TransactionDeleted;
use Instrument\Events\TransactionUpdated;

class Transaction extends InstrumentTransaction
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'account_id',
        'document_id',
        'amount',
        'payment_method',
        'paid_at',
        'meta'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'double',
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TransactionCreated::class,
        'updated' => TransactionUpdated::class,
        'deleted' => TransactionDeleted::class,
    ];
}