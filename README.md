# Introduction

A Laravel package to manage transaction documents.

## Installation

You can install the package via composer:

```bash
composer require starfolksoftware/instrument
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="instrument-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="instrument-config"
```

This is the contents of the published config file:

```php
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
```

## Usage

```php

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Faruk Nasir](https://github.com/starfolksoftware)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
