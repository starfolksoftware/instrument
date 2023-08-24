<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Report;

interface UpdatesReports
{
    /**
     * Update an existing report.
     */
    public function __invoke(Model $user, Report $report, array $data): Report;
}
