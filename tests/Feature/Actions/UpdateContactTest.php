<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\UpdatesContacts;
use StarfolkSoftware\Instrument\Events\ContactUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingContact;
use StarfolkSoftware\Instrument\Tests\Mocks\Contact;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
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
