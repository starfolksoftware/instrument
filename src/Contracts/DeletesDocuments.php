<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface DeletesDocuments
{
    /**
     * Delete an existing document.
     *
     * @param  mixed  $user
     * @param  mixed  $document
     * @return void
     */
    public function __invoke($user, $document);
}
