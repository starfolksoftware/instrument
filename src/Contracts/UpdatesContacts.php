<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface UpdatesContacts
{
    /**
     * Update an existing contact.
     *
     * @param  mixed  $user
     * @param  mixed  $contact
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $contact, array $data);
}
