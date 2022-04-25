<?php

use Illuminate\Support\Facades\Route;
use StarfolkSoftware\Instrument\Http\Controllers\AccountController;
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

    Route::resource('accounts', AccountController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.accounts.store', 'accounts.store'),
            'update' => config('instrument.route_names.accounts.update', 'accounts.update'),
            'destroy' => config('instrument.route_names.accounts.destroy', 'accounts.destroy'),
        ]);
});