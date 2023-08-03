<?php

use Illuminate\Support\Facades\Event;
use Instrument\Events\ContactCreated;
use Instrument\Events\ContactDeleted;
use Instrument\Events\ContactUpdated;
use Instrument\Events\CreatingContact;
use Instrument\Events\DeletingContact;
use Instrument\Events\UpdatingContact;
use Instrument\Tests\Mocks\Contact;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useContactModel(Contact::class);
});

test('contact can be created', function () {
    Event::fake();

    $user = TestUser::first();

    $response = actingAs($user)->post(route('contacts.store'), contactFields());

    $response->assertRedirect('/');

    Event::assertDispatched(CreatingContact::class);
    Event::assertDispatched(ContactCreated::class);

    expect(Contact::count())->toBe(1);
});

test('contact can be updated', function () {
    Event::fake();

    $user = TestUser::first();

    $contact = Contact::factory()->create();

    $fields = contactFields();

    $response = actingAs($user)->put(route('contacts.update', $contact), $fields);

    $response->assertRedirect('/');

    Event::assertDispatched(UpdatingContact::class);
    Event::assertDispatched(ContactUpdated::class);

    $this->assertDatabaseHas('contacts', [
        'name' => $fields['name'],
        'type' => $fields['type'],
    ]);
});

test('contact can be deleted', function () {
    Event::fake();

    $user = TestUser::first();

    $contact = Contact::factory()->create();

    $response = actingAs($user)->delete(route('contacts.destroy', $contact), [
        'redirect' => '/redirect/path',
    ]);

    $response->assertRedirect('/redirect/path');

    Event::assertDispatched(DeletingContact::class);
    Event::assertDispatched(ContactDeleted::class);

    expect(Contact::count())->toEqual(0);
});
