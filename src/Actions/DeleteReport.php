<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Report;
use Instrument\Contracts\DeletesReports;
use Instrument\Events\ReportDeleted;
use Instrument\Events\DeletingReport;

class DeleteReport implements DeletesReports
{
    /**
     * Delete a report.
     */
    public function __invoke(Model $user, Report $report): void
    {
        event(new DeletingReport($user, report: $report));

        $report->delete();

        event(new ReportDeleted(user: $user, report: $report));
    }
}
