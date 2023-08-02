<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use StarfolkSoftware\Instrument\Events\TaxCreated;
use StarfolkSoftware\Instrument\Events\TaxDeleted;
use StarfolkSoftware\Instrument\Events\TaxUpdated;
use StarfolkSoftware\Instrument\Tax as InstrumentTax;

class Tax extends InstrumentTax
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'name',
        'rate',
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
        return TaxFactory::new();
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TaxCreated::class,
        'updated' => TaxUpdated::class,
        'deleted' => TaxDeleted::class,
    ];
}
