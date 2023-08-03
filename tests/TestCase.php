<?php

namespace Instrument\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Instrument\InstrumentServiceProvider;
use Instrument\Tests\Mocks\TestUser;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Instrument\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->loadLaravelMigrations(['--database' => 'sqlite']);
        $this->createUser();
    }

    protected function getPackageProviders($app)
    {
        return [
            InstrumentServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('auth.providers.users.model', TestUser::class);
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        config()->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');

        $migration = include __DIR__.'/../database/migrations/create_instrument_table.php.stub';
        $migration->up();

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    protected function createUser()
    {
        TestUser::forceCreate([
            'name' => 'Faruk Nasir',
            'email' => 'faruk@starfolksoftware.com',
            'password' => 'test',
        ]);
    }
}
