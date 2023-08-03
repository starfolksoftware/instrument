<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Instrument\Account as InstrumentAccount;
use Instrument\Events\AccountCreated;
use Instrument\Events\AccountDeleted;
use Instrument\Events\AccountUpdated;

class Account extends InstrumentAccount
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'number',
        'opening_balance',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'number' => 'string',
        'opening_balance' => 'double',
        'meta' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AccountCreated::class,
        'updated' => AccountUpdated::class,
        'deleted' => AccountDeleted::class,
    ];
}