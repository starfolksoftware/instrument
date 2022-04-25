<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Events\DeletingDocument;
use StarfolkSoftware\Instrument\Events\DocumentDeleted;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
    \StarfolkSoftware\Instrument\Instrument::useDocumentModel(Document::class);
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
