<?php

namespace StarfolkSoftware\Instrument\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Document;
use StarfolkSoftware\Instrument\Events\CreatingDocument;
use StarfolkSoftware\Instrument\Events\DocumentCreated;
use StarfolkSoftware\Instrument\Instrument;

class CreateDocument implements CreatesDocuments
{
    /**
     * Create a new document.
     */
    public function __invoke(Model $user, array $data, $teamId = null): Document
    {
        event(new CreatingDocument(user: $user, data: $data));

        Validator::make($data, [
            'parent_id' => 'nullable|exists:documents,id',
            'number' => 'nullable|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'state' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'issued_at' => 'required|date|before_or_equal:due_at',
            'due_at' => 'required|date|after_or_equal:issued_at',
            'items' => 'required|array',
            'totals' => 'required|array',
            'meta' => 'nullable|array',
        ])->validateWithBag('createDocument');

        $fields = collect($data)->only([
            'parent_id',
            'number',
            'order_number',
            'state',
            'type',
            'issued_at',
            'due_at',
            'items',
            'totals',
            'meta',
        ])->toArray();

        $document = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->documents()->create($fields) :
            Instrument::newDocumentModel()->create($fields);

        event(new DocumentCreated(document: $document));

        return $document;
    }
}
