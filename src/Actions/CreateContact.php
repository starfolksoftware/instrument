<?php

namespace Instrument\Actions;

use Illuminate\Support\Facades\Validator;
use Instrument\Contracts\CreatesContacts;
use Instrument\Events\ContactCreated;
use Instrument\Events\CreatingContact;
use Instrument\Instrument;

class CreateContact implements CreatesContacts
{
    /**
     * Create a new tax.
     *
     * @param  mixed  $user
     * @param  array  $data
     * @param  mixed  $teamId
     * @return mixed
     */
    public function __invoke($user, array $data, $teamId = null)
    {
        event(new CreatingContact(user: $user, data: $data));

        Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'meta' => 'nullable|array',
        ])->validateWithBag('createContact');

        $fields = collect($data)->only([
            'name',
            'type',
            'meta',
        ])->toArray();

        $contact = Instrument::$supportsTeams ?
            Instrument::findTeamByIdOrFail($teamId)->contacts()->create($fields) :
            Instrument::newContactModel()->create($fields);

        event(new ContactCreated(user: $user, contact: $contact, data: $data));

        return $contact;
    }
}
