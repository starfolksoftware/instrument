<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesReports;
use Instrument\Events\ReportUpdated;
use Instrument\Events\UpdatingReport;
use Instrument\Tests\Mocks\Report;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
});

it('can update a report', function () {
    Event::fake();

    $updatesReports = app(UpdatesReports::class);

    $user = TestUser::first();

    $report = Report::factory()->create();

    $fields = reportFields();

    $report = $updatesReports(
        $user,
        $report,
        $fields
    );

    Event::assertDispatched(UpdatingReport::class);
    Event::assertDispatched(ReportUpdated::class);

    expect($report->name)->toBe($fields['name']);
    expect($report->type)->toBe($fields['type']);
});
