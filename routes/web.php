<?php

use Illuminate\Support\Facades\Route;
use StarfolkSoftware\Instrument\Http\Controllers;

Route::group([
    'middleware' => config('instrument.middleware', ['web']),
], function () {
    Route::resource('taxes', Controllers\TaxController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.taxes.store', 'taxes.store'),
            'update' => config('instrument.route_names.taxes.update', 'taxes.update'),
            'destroy' => config('instrument.route_names.taxes.destroy', 'taxes.destroy'),
        ]);

    Route::resource('documents', Controllers\DocumentController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.documents.store', 'documents.store'),
            'update' => config('instrument.route_names.documents.update', 'documents.update'),
            'destroy' => config('instrument.route_names.documents.destroy', 'documents.destroy'),
        ]);

    Route::resource('accounts', Controllers\AccountController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.accounts.store', 'accounts.store'),
            'update' => config('instrument.route_names.accounts.update', 'accounts.update'),
            'destroy' => config('instrument.route_names.accounts.destroy', 'accounts.destroy'),
        ]);

    Route::resource('transactions', Controllers\TransactionController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.transactions.store', 'transactions.store'),
            'update' => config('instrument.route_names.transactions.update', 'transactions.update'),
            'destroy' => config('instrument.route_names.transactions.destroy', 'transactions.destroy'),
        ]);
});