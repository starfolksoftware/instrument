<?php

use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Instrument;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TeamModel;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    Instrument::supportsTeams(true);

    Instrument::useDocumentModel(Document::class);

    Instrument::useTeamModel(TeamModel::class);
});

it('can create a document with team support', function () {
    $team = TeamModel::forceCreate(['name' => 'Test Team']);

    Instrument::supportsTeams();

    $createsDocuments = app(CreatesDocuments::class);

    $user = TestUser::first();

    $fields = documentFields();

    $document = $createsDocuments(
        $user,
        $fields,
        $team->id,
    );

    $document = $document->refresh();

    expect($document->parent_id)->toBe($fields['parent_id']);
    expect($document->type)->toBe($fields['type']);

    expect($document->team)
        ->id->toBe($team->id)
        ->name->toBe('Test Team');

    expect(
        $team->refresh()->documents()->count()
    )->toBe(1);
});
