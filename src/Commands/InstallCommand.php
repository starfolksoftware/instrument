<?php

namespace StarfolkSoftware\Instrument\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'instrument:install';

    public $description = 'Install the Instrument package and resources';

    public function handle(): int
    {
        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'instrument-config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--tag' => 'instrument-migrations', '--force' => true]);

        // Models...
        copy(__DIR__.'/../../stubs/app/Models/Document.php', app_path('Models/Document.php'));
        copy(__DIR__.'/../../stubs/app/Models/Account.php', app_path('Models/Account.php'));
        copy(__DIR__.'/../../stubs/app/Models/Tax.php', app_path('Models/Tax.php'));
        copy(__DIR__.'/../../stubs/app/Models/Currency.php', app_path('Models/Currency.php'));
        copy(__DIR__.'/../../stubs/app/Models/Transaction.php', app_path('Models/Transaction.php'));

        // Service Providers...
        copy(__DIR__.'/../../stubs/app/Providers/InstrumentServiceProvider.php', app_path('Providers/InstrumentServiceProvider.php'));

        $this->installServiceProviderAfter('RouteServiceProvider', 'InstrumentServiceProvider');

        return self::SUCCESS;
    }

    /**
     * Install the service provider in the application configuration file.
     *
     * @param  string  $after
     * @param  string  $name
     * @return void
     */
    protected function installServiceProviderAfter($after, $name)
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }
}
