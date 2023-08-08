<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Instrument\Currency as InstrumentCurrency;
use Instrument\Events\CurrencyCreated;
use Instrument\Events\CurrencyDeleted;
use Instrument\Events\CurrencyUpdated;

class Currency extends InstrumentCurrency
{
    use HasFactory;
    use SoftDeletes;

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