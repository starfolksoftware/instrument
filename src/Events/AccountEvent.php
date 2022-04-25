<?php

namespace StarfolkSoftware\Instrument\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class AccountEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @param  mixed  $account
     * @param  array  $data
     * @return void
     */
    public function __construct(
        public $user = null,
        public $account = null,
        public $data = []
    ) {
    }
}
