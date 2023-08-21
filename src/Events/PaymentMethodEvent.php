<?php

namespace Instrument\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class PaymentMethodEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @param  mixed  $paymentMethod
     * @param  array  $data
     * @return void
     */
    public function __construct(
        public $user = null,
        public $paymentMethod = null,
        public $data = []
    ) {
    }
}
