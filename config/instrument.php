<?php
// config for StarfolkSoftware/Instrument
return [
    'middleware' => ['web'],

    'redirects' => [
        'contacts' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'taxes' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'currencies' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'documents' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'accounts' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'transactions' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
    ],

    'route_names' => [
        'contacts' => [
            'store' => 'contacts.store',
            'update' => 'contacts.update',
            'destroy' => 'contacts.destroy',
        ],
        'currencies' => [
            'store' => 'currencies.store',
            'update' => 'currencies.update',
            'destroy' => 'currencies.destroy',
        ],
        'taxes' => [
            'store' => 'taxes.store',
            'update' => 'taxes.update',
            'destroy' => 'taxes.destroy',
        ],
        'documents' => [
            'store' => 'documents.store',
            'update' => 'documents.update',
            'destroy' => 'documents.destroy',
        ],
        'accounts' => [
            'store' => 'accounts.store',
            'update' => 'accounts.update',
            'destroy' => 'accounts.destroy',
        ],
        'transactions' => [
            'store' => 'transactions.store',
            'update' => 'transactions.update',
            'destroy' => 'transactions.destroy',
        ],
    ],
];
