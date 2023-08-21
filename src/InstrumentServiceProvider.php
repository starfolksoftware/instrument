<?php

namespace Instrument;

use Instrument\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InstrumentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('instrument')
            ->hasConfigFile()
            ->hasCommand(InstallCommand::class);

        if (Instrument::$runsMigrations) {
            $package->hasMigration('create_instrument_table');
        }

        if (Instrument::$registersRoutes) {
            $package->hasRoutes('web');
        }
    }

    public function packageRegistered()
    {
        Instrument::createDocumentsUsing(Actions\CreateDocument::class);

        Instrument::updateDocumentsUsing(Actions\UpdateDocument::class);

        Instrument::deleteDocumentsUsing(Actions\DeleteDocument::class);

        Instrument::createAccountsUsing(Actions\CreateAccount::class);

        Instrument::updateAccountsUsing(Actions\UpdateAccount::class);

        Instrument::deleteAccountsUsing(Actions\DeleteAccount::class);

        Instrument::createTransactionsUsing(Actions\CreateTransaction::class);

        Instrument::updateTransactionsUsing(Actions\UpdateTransaction::class);

        Instrument::deleteTransactionsUsing(Actions\DeleteTransaction::class);

        Instrument::createTaxesUsing(Actions\CreateTax::class);

        Instrument::updateTaxesUsing(Actions\UpdateTax::class);

        Instrument::deleteTaxesUsing(Actions\DeleteTax::class);

        Instrument::createCurrenciesUsing(Actions\CreateCurrency::class);

        Instrument::updateCurrenciesUsing(Actions\UpdateCurrency::class);

        Instrument::deleteCurrenciesUsing(Actions\DeleteCurrency::class);

        Instrument::createContactsUsing(Actions\CreateContact::class);

        Instrument::updateContactsUsing(Actions\UpdateContact::class);

        Instrument::deleteContactsUsing(Actions\DeleteContact::class);

        Instrument::createPaymentMethodsUsing(Actions\CreatePaymentMethod::class);

        Instrument::updatePaymentMethodsUsing(Actions\UpdatePaymentMethod::class);

        Instrument::deletePaymentMethodsUsing(Actions\DeletePaymentMethod::class);
    }
}
