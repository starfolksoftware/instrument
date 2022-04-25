<?php

use StarfolkSoftware\Instrument\Instrument;
use StarfolkSoftware\Instrument\Tests\Mocks\Document;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useDocumentModel(Document::class);
});

test('document can be created', function () {
    $user = TestUser::first();

    $response = actingAs($user)->post(route('documents.store'), documentFields());

    $response->assertRedirect('/');

    expect(Document::count())->toBe(1);
});

test('document can be updated', function () {
    $user = TestUser::first();

    $document = Document::factory()->create();

    $fields = documentFields();

    $response = actingAs($user)->put(route('documents.update', $document), $fields);

    $response->assertRedirect('/');

    $this->assertDatabaseHas('documents', [
        'parent_id' => $fields['parent_id'],
        'type' => $fields['type'],
    ]);
});

test('document can be deleted', function () {
    $user = TestUser::first();

    $document = Document::factory()->create();

    $response = actingAs($user)->delete(route('documents.destroy', $document), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    expect(Document::count())->toEqual(0);
});