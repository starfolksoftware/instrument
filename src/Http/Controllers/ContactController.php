<?php

namespace Instrument\Http\Controllers;

use Instrument\Contracts\CreatesContacts;
use Instrument\Contracts\DeletesContacts;
use Instrument\Contracts\UpdatesContacts;
use Instrument\Instrument;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatesContacts  $createsContacts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesContacts $createsContacts)
    {
        $contact = $createsContacts(
            request()->user(),
            request()->all(),
            request('team_id'),
        );

        return request()->wantsJson() ? response()->json(['contact' => $contact]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('contacts', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $contact
     * @param  UpdatesContacts  $updatesContacts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($contact, UpdatesContacts $updatesContacts)
    {
        $contact = Instrument::newContactModel()->findOrFail($contact);

        $contact = $updatesContacts(
            request()->user(),
            $contact,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['contact' => $contact]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('contacts', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $contact
     * @param  \Instrument\Contracts\DeletesContacts  $deletesContacts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($contact, DeletesContacts $deletesContacts)
    {
        $contact = Instrument::newContactModel()->findOrFail($contact);

        $deletesContacts(
            request()->user(),
            $contact
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('contacts', 'destroy', '/'))
        );
    }
}
