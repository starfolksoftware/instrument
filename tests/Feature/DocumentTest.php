<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\CreatingDocument;
use Instrument\Events\DeletingDocument;
use Instrument\Events\DocumentCreated;
use Instrument\Events\DocumentDeleted;
use Instrument\Events\DocumentUpdated;
use Instrument\Events\UpdatingDocument;
use Instrument\Tests\Mocks\Document;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useDocumentModel(Document::class);
});

test('document can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('documents.store'), documentFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingDocument::class);
    Event::assertDispatched(DocumentCreated::class);

    expect(Document::count())->toBe(1);
});

test('document can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $document = Document::factory()->create();

    $fields = documentFields();

    $response = actingAs($user)->put(route('documents.update', $document), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingDocument::class);
    Event::assertDispatched(DocumentUpdated::class);

    $this->assertDatabaseHas('documents', [
        'parent_id' => $fields['parent_id'],
        'type' => $fields['type'],
    ]);
});

test('document can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $document = Document::factory()->create();

    $response = actingAs($user)->delete(route('documents.destroy', $document), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingDocument::class);
    Event::assertDispatched(DocumentDeleted::class);

    expect(Document::count())->toEqual(0);
});
