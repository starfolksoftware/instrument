<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Instrument\Report as InstrumentReport;
use Instrument\Events\ReportCreated;
use Instrument\Events\ReportDeleted;
use Instrument\Events\ReportUpdated;

class Report extends InstrumentReport
{
    use HasFactory;
    use SoftDeletes;

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