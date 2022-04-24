<?php

namespace StarfolkSoftware\Instrument\Commands;

use Illuminate\Console\Command;

class InstrumentCommand extends Command
{
    public $signature = 'instrument';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
