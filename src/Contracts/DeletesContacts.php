<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface DeletesContacts
{
    /**
     * Delete an existing contact.
     *
     * @param  mixed  $user
     * @param  mixed  $contact
     * @return void
     */
    public function __invoke($user, $contact);
}
