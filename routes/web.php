<?php

use Illuminate\Support\Facades\Route;
use Instrument\Http\Controllers;

Route::group([
    'middleware' => config('instrument.middleware', ['web']),
], function () {
    Route::resource('contacts', Controllers\ContactController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.contacts.store', 'contacts.store'),
            'update' => config('instrument.route_names.contacts.update', 'contacts.update'),
            'destroy' => config('instrument.route_names.contacts.destroy', 'contacts.destroy'),
        ]);

    Route::resource('taxes', Controllers\TaxController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.taxes.store', 'taxes.store'),
            'update' => config('instrument.route_names.taxes.update', 'taxes.update'),
            'destroy' => config('instrument.route_names.taxes.destroy', 'taxes.destroy'),
        ]);

    Route::resource('currencies', Controllers\CurrencyController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.currencies.store', 'currencies.store'),
            'update' => config('instrument.route_names.currencies.update', 'currencies.update'),
            'destroy' => config('instrument.route_names.currencies.destroy', 'currencies.destroy'),
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

    Route::resource('payment-methods', Controllers\PaymentMethodController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.payment-methods.store', 'payment-methods.store'),
            'update' => config('instrument.route_names.payment-methods.update', 'payment-methods.update'),
            'destroy' => config('instrument.route_names.payment-methods.destroy', 'payment-methods.destroy'),
        ]);

    Route::resource('transactions', Controllers\TransactionController::class)
        ->only(['store', 'update', 'destroy'])
        ->names([
            'store' => config('instrument.route_names.transactions.store', 'transactions.store'),
            'update' => config('instrument.route_names.transactions.update', 'transactions.update'),
            'destroy' => config('instrument.route_names.transactions.destroy', 'transactions.destroy'),
        ]);
});