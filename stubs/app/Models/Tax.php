<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Instrument\Tax as InstrumentTax;
use Instrument\Events\TaxCreated;
use Instrument\Events\TaxDeleted;
use Instrument\Events\TaxUpdated;

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