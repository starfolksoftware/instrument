<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\ReportCreated;
use Instrument\Events\ReportDeleted;
use Instrument\Events\ReportUpdated;
use Instrument\Events\CreatingReport;
use Instrument\Events\DeletingReport;
use Instrument\Events\UpdatingReport;
use Instrument\Tests\Mocks\Report;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useReportModel(Report::class);
});

test('report can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('reports.store'), reportFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingReport::class);
    Event::assertDispatched(ReportCreated::class);

    expect(Report::count())->toBe(1);
});

test('report can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $report = Report::factory()->create();

    $fields = reportFields();

    $response = actingAs($user)->put(route('reports.update', $report), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingReport::class);
    Event::assertDispatched(ReportUpdated::class);

    $this->assertDatabaseHas('reports', [
        'name' => $fields['name'],
        'type' => $fields['type'],
    ]);
});

test('report can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $report = Report::factory()->create();

    $response = actingAs($user)->delete(route('reports.destroy', $report), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingReport::class);
    Event::assertDispatched(ReportDeleted::class);

    expect(Report::count())->toEqual(0);
});
