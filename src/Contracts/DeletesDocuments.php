<?php

namespace Instrument\Contracts;

use Illuminate\Database\Eloquent\Model;
use Instrument\Document;

interface DeletesDocuments
{
    /**
     * Delete an existing document.
     */
    public function __invoke(Model $user, Document $document): void;
}
