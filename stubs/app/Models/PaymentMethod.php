<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Instrument\PaymentMethod as InstrumentPaymentMethod;
use Instrument\Events\PaymentMethodCreated;
use Instrument\Events\PaymentMethodDeleted;
use Instrument\Events\PaymentMethodUpdated;

class PaymentMethod extends InstrumentPaymentMethod
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
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
        'created' => PaymentMethodCreated::class,
        'updated' => PaymentMethodUpdated::class,
        'deleted' => PaymentMethodDeleted::class,
    ];
}