<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\UpdatesDocuments;
use StarfolkSoftware\Instrument\Events\DocumentUpdated;
use StarfolkSoftware\Instrument\Events\UpdatingDocument;

class UpdateDocument implements UpdatesDocuments
{
    /**
     * Update an existing document.
     *
     * @param  mixed  $user
     * @param  mixed  $document
     * @param  array  $data
     * @return mixed
     */
    public function __invoke($user, $document, array $data)
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
