<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface UpdatesDocuments
{
    /**
     * Update an existing document.
     *
     * @param  mixed  $user
     * @param  mixed  $document
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $document, array $data);
}
