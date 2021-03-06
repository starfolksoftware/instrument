<?php

namespace StarfolkSoftware\Instrument\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class TransactionEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @param  mixed  $transaction
     * @param  array  $data
     * @return void
     */
    public function __construct(
        public $user = null,
        public $transaction = null,
        public $data = []
    ) {
    }
}
