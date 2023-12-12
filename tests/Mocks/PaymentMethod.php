<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Instrument\Events\PaymentMethodCreated;
use Instrument\Events\PaymentMethodDeleted;
use Instrument\Events\PaymentMethodUpdated;
use Instrument\PaymentMethod as InstrumentPaymentMethod;

class PaymentMethod extends InstrumentPaymentMethod
{
    use HasFactory;

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
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PaymentMethodFactory::new();
    }

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
