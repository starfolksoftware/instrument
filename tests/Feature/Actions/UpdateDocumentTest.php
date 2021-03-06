<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\UpdatesDocuments;
use StarfolkSoftware\Instrument\Events\DocumentUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingDocument;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
});

it('can update a document', function () {
    Event::fake();

    $updatesDocuments = app(UpdatesDocuments::class);

    $user = TestUser::first();

    $document = Document::factory()->create();

    $fields = documentFields();

    $document = $updatesDocuments(
        $user,
        $document,
        $fields
    );

    Event::assertDispatched(UpdatingDocument::class);
    Event::assertDispatched(DocumentUpdated::class);

    expect($document->parent_id)->toBe($fields['parent_id']);
    expect($document->type)->toBe($fields['type']);
});
