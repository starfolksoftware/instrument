<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Events\CreatingDocument;
use StarfolkSoftware\Instrument\Events\DeletingDocument;
use StarfolkSoftware\Instrument\Events\DocumentCreated;
use StarfolkSoftware\Instrument\Events\DocumentDeleted;
use StarfolkSoftware\Instrument\Events\DocumentUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingDocument;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useDocumentModel(Document::class);
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
