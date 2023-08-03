<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Instrument\Document as InstrumentDocument;
use Instrument\Events\DocumentCreated;
use Instrument\Events\DocumentDeleted;
use Instrument\Events\DocumentUpdated;

class Document extends InstrumentDocument
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'number',
        'order_number',
        'state',
        'type',
        'issued_at',
        'due_at',
        'items',
        'totals',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'items' => 'array',
        'totals' => 'array',
        'meta' => 'array',
        'issued_at' => 'datetime',
        'due_at' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return DocumentFactory::new();
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => DocumentCreated::class,
        'updated' => DocumentUpdated::class,
        'deleted' => DocumentDeleted::class,
    ];
}
