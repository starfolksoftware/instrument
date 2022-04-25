<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Events\CreatingDocument;
use StarfolkSoftware\Instrument\Events\DocumentCreated;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useDocumentModel(Document::class);
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
