<?php

namespace StarfolkSoftware\Instrument\Actions;

use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Events\DeletingDocument;
use StarfolkSoftware\Instrument\Events\DocumentDeleted;

class DeleteDocument implements DeletesDocuments
{
    /**
     * Delete a document.
     *
     * @param  mixed  $user
     * @param  mixed  $document
     * @return void
     */
    public function __invoke($user, $document)
    {
        event(new DeletingDocument(user: $user, document: $document));

        $document->delete();

        event(new DocumentDeleted(user: $user, document: $document));
    }
}
