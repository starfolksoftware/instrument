<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\CreatesContacts;
use Instrument\Events\ContactCreated;
use Instrument\Events\CreatingContact;
use Instrument\Tests\Mocks\Contact;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);

    \Instrument\Instrument::useContactModel(Contact::class);
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
