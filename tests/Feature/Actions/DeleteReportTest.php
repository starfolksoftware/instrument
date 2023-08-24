<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesReports;
use Instrument\Events\ReportDeleted;
use Instrument\Events\DeletingReport;
use Instrument\Tests\Mocks\Report;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useReportModel(Report::class);
});

it('can delete a report', function () {
    Event::fake();

    $deletesReports = app(DeletesReports::class);

    $user = TestUser::first();

    $report = Report::factory()->create();

    $deletesReports($user, $report);

    Event::assertDispatched(DeletingReport::class);
    Event::assertDispatched(ReportDeleted::class);

    expect(Report::count())->toEqual(0);
});
