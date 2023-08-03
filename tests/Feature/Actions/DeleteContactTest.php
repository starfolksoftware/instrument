<?php

use Illuminate\Support\Facades\Event;
use Instrument\Contracts\DeletesContacts;
use Instrument\Events\ContactDeleted;
use Instrument\Events\DeletingContact;
use Instrument\Tests\Mocks\Contact;
use Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \Instrument\Instrument::supportsTeams(false);
    \Instrument\Instrument::useContactModel(Contact::class);
});

it('can delete an contact', function () {
    Event::fake();

    $deletesContacts = app(DeletesContacts::class);

    $user = TestUser::first();

    $contact = Contact::factory()->create();

    $deletesContacts($user, $contact);

    Event::assertDispatched(DeletingContact::class);
    Event::assertDispatched(ContactDeleted::class);

    expect(Contact::count())->toEqual(0);
});
