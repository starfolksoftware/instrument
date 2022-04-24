<?php

namespace StarfolkSoftware\Instrument;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use StarfolkSoftware\Instrument\Commands\InstrumentCommand;

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
            ->hasViews()
            ->hasMigration('create_instrument_table')
            ->hasCommand(InstrumentCommand::class);
    }
}
