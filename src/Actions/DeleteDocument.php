<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Document;
use StarfolkSoftware\Instrument\Events\DeletingDocument;
use StarfolkSoftware\Instrument\Events\DocumentDeleted;

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
