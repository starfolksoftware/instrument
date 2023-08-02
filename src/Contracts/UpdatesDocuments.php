<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Document;

interface UpdatesDocuments
{
    /**
     * Update an existing document.
     */
    public function __invoke(Model $user, Document $document, array $data): Document;
}
