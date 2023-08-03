<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\UpdatesContacts;
use Instrument\Events\ContactUpdated;
use Instrument\Events\UpdatingContact;
use Instrument\Tests\Mocks\Contact;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
});

it('can update an contact', function () {
    Event::fake();

    $updatesContacts = app(UpdatesContacts::class);

    $user = TestUser::first();

    $contact = Contact::factory()->create();

    $fields = contactFields();

    $contact = $updatesContacts(
        $user,
        $contact,
        $fields
    );

    Event::assertDispatched(UpdatingContact::class);
    Event::assertDispatched(ContactUpdated::class);

    expect($contact->name)->toBe($fields['name']);
    expect($contact->type)->toBe($fields['type']);
});
