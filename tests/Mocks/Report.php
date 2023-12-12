<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Instrument\Events\ReportCreated;
use Instrument\Events\ReportDeleted;
use Instrument\Events\ReportUpdated;
use Instrument\Report as InstrumentReport;

class Report extends InstrumentReport
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'name',
        'description',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ReportFactory::new();
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ReportCreated::class,
        'updated' => ReportUpdated::class,
        'deleted' => ReportDeleted::class,
    ];
}
