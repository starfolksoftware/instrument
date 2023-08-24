<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Report;

interface CreatesReports
{
    /**
     * Create a new report.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Report;
}
