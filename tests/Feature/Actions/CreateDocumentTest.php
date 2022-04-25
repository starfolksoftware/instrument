<?php

use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useDocumentModel(Document::class);
});

it('can create a document', function () {
    $createsDocuments = app(CreatesDocuments::class);

    $user = TestUser::first();

    $documentFields = Document::factory()->raw();

    $document = $createsDocuments(
        $user,
        $documentFields
    );

    expect($document->parent_id)->toBe($documentFields['parent_id']);
    expect($document->type)->toBe($documentFields['type']);
});
