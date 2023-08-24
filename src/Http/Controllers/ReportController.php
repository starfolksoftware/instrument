<?php

namespace Instrument\Http\Controllers;

use Instrument\Contracts\CreatesReports;
use Instrument\Contracts\DeletesReports;
use Instrument\Contracts\UpdatesReports;
use Instrument\Instrument;

class ReportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Instrument\Contracts\CreatesReports  $createsReports
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesReports $createsReports)
    {
        $report = $createsReports(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['report' => $report]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('reports', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $report
     * @param  \Instrument\Contracts\UpdatesReports  $updatesReports
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($report, UpdatesReports $updatesReports)
    {
        $report = Instrument::newReportModel()->findOrFail($report);

        $report = $updatesReports(
            request()->user(),
            $report,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['report' => $report]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('reports', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $report
     * @param  \Instrument\Contracts\DeletesReports  $deletesReports
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($report, DeletesReports $deletesReports)
    {
        $report = Instrument::newReportModel()->findOrFail($report);

        $deletesReports(
            request()->user(),
            $report
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('reports', 'destroy', '/'))
        );
    }
}
