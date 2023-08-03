<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Document;

interface UpdatesDocuments
{
    /**
     * Update an existing document.
     */
    public function __invoke(Model $user, Document $document, array $data): Document;
}
