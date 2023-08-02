<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use StarfolkSoftware\Instrument\Contact as InstrumentContact;
use StarfolkSoftware\Instrument\Events\ContactCreated;
use StarfolkSoftware\Instrument\Events\ContactDeleted;
use StarfolkSoftware\Instrument\Events\ContactUpdated;

class Contact extends InstrumentContact
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'type',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ContactCreated::class,
        'updated' => ContactUpdated::class,
        'deleted' => ContactDeleted::class,
    ];
}