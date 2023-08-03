<?php

namespace Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Instrument\Contracts\UpdatesDocuments;
use Instrument\Document;
use Instrument\Events\DocumentUpdated;
use Instrument\Events\UpdatingDocument;

class UpdateDocument implements UpdatesDocuments
{
    /**
     * Update an existing document.
     */
    public function __invoke(Model $user, Document $document, array $data): Document
    {
        event(new UpdatingDocument(user: $user, document: $document, data: $data));

        Validator::make($data, [
            'number' => 'nullable|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'issued_at' => 'required|date|before_or_equal:due_at',
            'due_at' => 'required|date|after_or_equal:issued_at',
            'items' => 'required|array',
            'totals' => 'required|array',
            'meta' => 'nullable|array',
        ])->validateWithBag('updateDocument');

        $document->update(collect($data)->only([
            'number',
            'order_number',
            'state',
            'type',
            'issued_at',
            'due_at',
            'items',
            'totals',
            'meta',
        ])->toArray());

        event(new DocumentUpdated(user: $user, document: $document));

        return $document->refresh();
    }
}
