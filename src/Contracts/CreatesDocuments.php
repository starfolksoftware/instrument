<?php

namespace StarfolkSoftware\Instrument\Contracts;

interface CreatesDocuments
{
    /**
     * Create a new document.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return mixed
     */
    public function __invoke($user, array $data, $teamId = null);
}
