<?php
// config for StarfolkSoftware/Instrument
return [
    'middleware' => ['web'],

    'redirects' => [
        'store' => null,
        'update' => null,
        'destroy' => '/',
    ],

    'route_names' => [
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
