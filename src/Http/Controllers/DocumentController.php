<?php

namespace StarfolkSoftware\Instrument\Http\Controllers;

use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Contracts\UpdatesDocuments;
use StarfolkSoftware\Instrument\Instrument;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \StarfolkSoftware\Instrument\Contracts\CreatesDocuments  $createsDocuments
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesDocuments $createsDocuments)
    {
        $document = $createsDocuments(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['document' => $document]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('documents', 'store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $document
     * @param  \StarfolkSoftware\Instrument\Contracts\UpdatesDocuments  $updatesDocuments
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($document, UpdatesDocuments $updatesDocuments)
    {
        $document = Instrument::newDocumentModel()->findOrFail($document);

        $document = $updatesDocuments(
            request()->user(),
            $document,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['document' => $document]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('documents', 'update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $document
     * @param  \StarfolkSoftware\Instrument\Contracts\DeletesDocuments  $deletesDocuments
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($document, DeletesDocuments $deletesDocuments)
    {
        $document = Instrument::newDocumentModel()->findOrFail($document);

        $deletesDocuments(
            request()->user(),
            $document
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('documents', 'destroy', '/'))
        );
    }
}
