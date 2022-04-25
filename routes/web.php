<?php

use Illuminate\Support\Facades\Route;
use StarfolkSoftware\Instrument\Http\Controllers\DocumentController;

Route::group([
    'middleware' => config('instrument.middleware', ['web']),
], function () {
    Route::resource('documents', DocumentController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.documents.store', 'documents.store'),
            'update' => config('instrument.route_names.documents.update', 'documents.update'),
            'destroy' => config('instrument.route_names.documents.destroy', 'documents.destroy'),
        ]);
});