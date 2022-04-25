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
    ],
];
