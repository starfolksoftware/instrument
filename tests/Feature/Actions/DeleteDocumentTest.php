<?php

use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useDocumentModel(Document::class);
});

it('can delete a document', function () {
    $deletesDocuments = app(DeletesDocuments::class);

    $user = TestUser::first();

    $document = Document::factory()->create();

    $deletesDocuments($user, $document);

    expect(Document::count())->toEqual(0);
});
