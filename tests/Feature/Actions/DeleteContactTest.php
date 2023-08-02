<?php

use Illuminate\Support\Facades\Event;
use StarfolkSoftware\Instrument\Contracts\DeletesContacts;
use StarfolkSoftware\Instrument\Events\DeletingContact;
use StarfolkSoftware\Instrument\Events\ContactDeleted;
use StarfolkSoftware\Instrument\Tests\Mocks\Contact;
use StarfolkSoftware\Instrument\Tests\Mocks\TestUser;

beforeAll(function () {
    \StarfolkSoftware\Instrument\Instrument::supportsTeams(false);
    \StarfolkSoftware\Instrument\Instrument::useContactModel(Contact::class);
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
