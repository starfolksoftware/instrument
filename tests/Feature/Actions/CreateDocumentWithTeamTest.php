<?php

use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Instrument;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TeamModel;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    Instrument::supportsTeams(true);

    Instrument::useDocumentModel(Document::class);
});

it('can create a document with team support', function () {
    $team = TeamModel::forceCreate(['name' => 'Test Team']);

    Instrument::supportsTeams();

    Instrument::useTeamModel(TeamModel::class);

    $createsDocuments = app(CreatesDocuments::class);

    $user = TestUser::first();

    $document = $createsDocuments(
        $user,
        documentFields(),
        $team->id,
    );

    $document = $document->refresh();

    expect($document->parent_id)->toBe(documentFields()['parent_id']);
    expect($document->type)->toBe(documentFields()['type']);

    expect($document->team)
        ->id->toBe($team->id)
        ->name->toBe('Test Team');

    expect(
        $team->refresh()->documents()->count()
    )->toBe(1);
});
