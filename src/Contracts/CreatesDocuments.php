<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Document;

interface CreatesDocuments
{
    /**
     * Create a new document.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Document;
}
