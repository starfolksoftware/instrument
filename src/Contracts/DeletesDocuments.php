<?php

namespace StarfolkSoftware\Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Document;

interface DeletesDocuments
{
    /**
     * Delete an existing document.
     */
    public function __invoke(Model $user, Document $document): void;
}
