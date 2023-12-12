<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Contracts\UpdatesReports;
use Instrument\Events\ReportUpdated;
use Instrument\Events\UpdatingReport;
use Instrument\Report;

class UpdateReport implements UpdatesReports
{
    /**
     * Update an existing report.
     */
    public function __invoke(Model $user, Report $report, array $data): Report
    {
        event(new UpdatingReport(user: $user, report: $report, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'settings' => 'nullable|array',
            'settings.group' => 'nullable|string|max:255|in:'.implode(',', config('instrument.report_groups')),
            'settings.period' => 'nullable|string|max:255|in:'.implode(',', config('instrument.report_periods')),
            'settings.basis' => 'nullable|string|max:255|in:'.implode(',', config('instrument.report_accounting_basis')),
        ])->validateWithBag('updateReport');

        $report->update(collect($data)->only([
            'name',
            'description',
            'settings',
        ])->toArray());

        event(new ReportUpdated(user: $user, report: $report, data: $data));

        return $report->refresh();
    }
}
