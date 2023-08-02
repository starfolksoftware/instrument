<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\CreatesContacts;
use StarfolkSoftware\Instrument\Events\CreatingContact;
use StarfolkSoftware\Instrument\Events\ContactCreated;
use StarfolkSoftware\Instrument\Tests\Mocks\Contact;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);

    \StarfolkSoftware\Instrument\Instrument::useContactModel(Contact::class);
});

it('can create an contact', function () {
    Event::fake();

    $createsContacts = app(CreatesContacts::class);

    $user = TestUser::first();

    $contactFields = contactFields();

    $contact = $createsContacts(
        $user,
        $contactFields
    );

    Event::assertDispatched(CreatingContact::class);
    Event::assertDispatched(ContactCreated::class);

    expect($contact->name)->toBe($contactFields['name']);
    expect($contact->type)->toBe($contactFields['type']);
});
