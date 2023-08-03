<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Instrument\Contracts\DeletesDocuments;
use Instrument\Document;
use Instrument\Events\DeletingDocument;
use Instrument\Events\DocumentDeleted;

class DeleteDocument implements DeletesDocuments
{
    /**
     * Delete a document.
     */
    public function __invoke(Model $user, Document $document): void
    {
        event(new DeletingDocument($user, document: $document));

        $document->delete();

        event(new DocumentDeleted(user: $user, document: $document));
    }
}
