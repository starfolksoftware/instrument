<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesDocuments;
use Instrument\Events\CreatingDocument;
use Instrument\Events\DocumentCreated;
use Instrument\Tests\Mocks\Document;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useDocumentModel(Document::class);
});

it('can create a document', function () {
    Event::fake();

    $createsDocuments = app(CreatesDocuments::class);

    $user = TestUser::first();

    $documentFields = documentFields();

    $document = $createsDocuments(
        $user,
        $documentFields
    );

    Event::assertDispatched(CreatingDocument::class);
    Event::assertDispatched(DocumentCreated::class);

    expect($document->parent_id)->toBe($documentFields['parent_id']);
    expect($document->type)->toBe($documentFields['type']);
});
