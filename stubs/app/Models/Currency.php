<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use StarfolkSoftware\Instrument\Currency as InstrumentCurrency;
use StarfolkSoftware\Instrument\Events\CurrencyCreated;
use StarfolkSoftware\Instrument\Events\CurrencyDeleted;
use StarfolkSoftware\Instrument\Events\CurrencyUpdated;

class Currency extends InstrumentCurrency
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'team_id',
        'name',
        'code',
        'rate',
        'precision',
        'symbol',
        'symbol_position',
        'decimal_mark',
        'thousands_separator',
        'enabled',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CurrencyCreated::class,
        'updated' => CurrencyUpdated::class,
        'deleted' => CurrencyDeleted::class,
    ];
}