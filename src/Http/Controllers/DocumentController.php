<?php

namespace StarfolkSoftware\Instrument\Http\Controllers;

use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Contracts\UpdatesDocuments;
use StarfolkSoftware\Instrument\Instrument;
use StarfolkSoftware\Instrument\Document;

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
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['document' => $document]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \StarfolkSoftware\Instrument\Document  $document
     * @param  \StarfolkSoftware\Instrument\Contracts\UpdatesDocuments  $updatesDocuments
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Document $document, UpdatesDocuments $updatesDocuments)
    {
        $document = $updatesDocuments(
            request()->user(),
            $document,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['document' => $document]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \StarfolkSoftware\Instrument\Document  $document
     * @param  \StarfolkSoftware\Instrument\Contracts\DeletesDocuments  $deletesDocuments
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Document $document, DeletesDocuments $deletesDocuments)
    {
        $deletesDocuments(
            request()->user(),
            $document
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Instrument::redirects('destroy', '/'))
        );
    }
}
