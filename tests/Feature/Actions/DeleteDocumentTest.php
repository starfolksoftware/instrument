<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesDocuments;
use Instrument\Events\DeletingDocument;
use Instrument\Events\DocumentDeleted;
use Instrument\Tests\Mocks\Document;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useDocumentModel(Document::class);
});

it('can delete a document', function () {
    Event::fake();

    $deletesDocuments = app(DeletesDocuments::class);

    $user = TestUser::first();

    $document = Document::factory()->create();

    $deletesDocuments($user, $document);

    Event::assertDispatched(DeletingDocument::class);
    Event::assertDispatched(DocumentDeleted::class);

    expect(Document::count())->toEqual(0);
});
