<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesReports;
use Instrument\Events\CreatingReport;
use Instrument\Events\ReportCreated;
use Instrument\Tests\Mocks\Report;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useReportModel(Report::class);
});

it('can create a report', function () {
    Event::fake();

    $createsReports = app(CreatesReports::class);

    $user = TestUser::first();

    $reportFields = reportFields();

    $report = $createsReports(
        $user,
        $reportFields
    );

    Event::assertDispatched(CreatingReport::class);
    Event::assertDispatched(ReportCreated::class);

    expect($report->name)->toBe($reportFields['name']);
    expect($report->type)->toBe($reportFields['type']);
});
