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
        'payment-methods' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'transactions' => [
            'store' => null,
            'update' => null,
            'destroy' => '/',
        ],
        'reports' => [
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
        'payment-methods' => [
            'store' => 'payment-methods.store',
            'update' => 'payment-methods.update',
            'destroy' => 'payment-methods.destroy',
        ],
        'transactions' => [
            'store' => 'transactions.store',
            'update' => 'transactions.update',
            'destroy' => 'transactions.destroy',
        ],
        'reports' => [
            'store' => 'reports.store',
            'update' => 'reports.update',
            'destroy' => 'reports.destroy',
        ],
    ],

    /*
     * The types
     */
    'report_types' => [
        'expense' => Expense::class,
        'income' => Income::class,
        'profit_and_loss' => ProfitLoss::class,
        'tax' => Tax::class,
    ],

    /**
     * Group Options.
     */
    'report_groups' => [
        'category',
        'customer',
        'item',
    ],

    /**
     * Period Options.
     */
    'report_periods' => [
        'monthly',
        'quarterly',
        'yearly',
    ],

    /**
     * Basis Options.
     */
    'report_accounting_basis' => [
        'cash',
        'accrual',
    ],

    /**
     * Chart Options.
     */
    'report_charts' => [
        // 'none',
        // 'line',
    ],
];
