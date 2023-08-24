<?php

namespace Instrument\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class ReportEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @param  mixed  $report
     * @param  array  $data
     * @return void
     */
    public function __construct(
        public $user = null,
        public $report = null,
        public $data = []
    ) {
    }
}
