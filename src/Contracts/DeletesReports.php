<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Report;

interface DeletesReports
{
    /**
     * Delete an existing report.
     */
    public function __invoke(Model $user, Report $report): void;
}
