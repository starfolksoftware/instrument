<?php

namespace StarfolkSoftware\Instrument\Actions;

use StarfolkSoftware\Instrument\Contracts\DeletesContacts;
use StarfolkSoftware\Instrument\Events\ContactDeleted;
use StarfolkSoftware\Instrument\Events\DeletingContact;

class DeleteContact implements DeletesContacts
{
    /**
     * Delete a contact.
     *
     * @param  mixed  $user
     * @param  mixed  $contact
     * @return void
     */
    public function __invoke($user, $contact)
    {
        event(new DeletingContact(user: $user, contact: $contact));

        $contact->delete();

        event(new ContactDeleted(user: $user, contact: $contact));
    }
}
