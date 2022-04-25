<?php

namespace StarfolkSoftware\Instrument;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use StarfolkSoftware\Instrument\Actions\CreateAccount;
use StarfolkSoftware\Instrument\Actions\CreateDocument;
use StarfolkSoftware\Instrument\Actions\CreateTransaction;
use StarfolkSoftware\Instrument\Actions\DeleteAccount;
use StarfolkSoftware\Instrument\Actions\DeleteDocument;
use StarfolkSoftware\Instrument\Actions\DeleteTransaction;
use StarfolkSoftware\Instrument\Actions\UpdateAccount;
use StarfolkSoftware\Instrument\Actions\UpdateDocument;
use StarfolkSoftware\Instrument\Actions\UpdateTransaction;
use StarfolkSoftware\Instrument\Commands\InstallCommand;

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
        Instrument::createDocumentsUsing(CreateDocument::class);

        Instrument::updateDocumentsUsing(UpdateDocument::class);

        Instrument::deleteDocumentsUsing(DeleteDocument::class);

        Instrument::createAccountsUsing(CreateAccount::class);

        Instrument::updateAccountsUsing(UpdateAccount::class);

        Instrument::deleteAccountsUsing(DeleteAccount::class);

        Instrument::createTransactionsUsing(CreateTransaction::class);

        Instrument::updateTransactionsUsing(UpdateTransaction::class);

        Instrument::deleteTransactionsUsing(DeleteTransaction::class);
    }
}
