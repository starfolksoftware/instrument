<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use StarfolkSoftware\Instrument\Events\CurrencyCreated;
use StarfolkSoftware\Instrument\Events\CurrencyDeleted;
use StarfolkSoftware\Instrument\Events\CurrencyUpdated;
use StarfolkSoftware\Instrument\Currency as InstrumentCurrency;

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
     * @var string[]
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
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }

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
