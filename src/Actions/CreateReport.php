<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Report;
use Instrument\Contracts\CreatesReports;
use Instrument\Events\ReportCreated;
use Instrument\Events\CreatingReport;
use Instrument\Instrument;

class CreateReport implements CreatesReports
{
    /**
     * Create a new report.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Report
    {
        event(new CreatingReport(user: $user, data: $data));

        Validator::make($data, [
            'type' => 'required|string|max:255|in:'.implode(',', collect(config('instrument.report_types'))->keys()->toArray()),
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'settings' => 'nullable|array',
            'settings.group' => 'nullable|string|max:255|in:'.implode(',', config('instrument.report_groups')),
            'settings.period' => 'nullable|string|max:255|in:'.implode(',', config('instrument.report_periods')),
            'settings.basis' => 'nullable|string|max:255|in:'.implode(',', config('instrument.report_accounting_basis')),
        ])->validateWithBag('createReport');

        $fields = collect($data)->only([
            'type',
            'name',
            'description',
            'settings',
        ])->toArray();

        $report = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->reports()->create($fields) :
            Instrument::newReportModel()->create($fields);

        event(new ReportCreated(user: $user, report: $report, data: $data));

        return $report;
    }
}
