<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Contracts\DeletesReports;
use Instrument\Events\DeletingReport;
use Instrument\Events\ReportDeleted;
use Instrument\Report;

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
