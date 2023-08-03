<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesDocuments;
use Instrument\Events\DocumentUpdated;
use Instrument\Events\UpdatingDocument;
use Instrument\Tests\Mocks\Document;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
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
