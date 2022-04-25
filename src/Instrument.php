<?php

namespace StarfolkSoftware\Instrument;

use StarfolkSoftware\Instrument\Contracts\CreatesDocuments;
use StarfolkSoftware\Instrument\Contracts\DeletesDocuments;
use StarfolkSoftware\Instrument\Contracts\UpdatesDocuments;

class Instrument
{
    /**
     * Indicates if Instrument routes will be registered.
     *
     * @var bool
     */
    public static $registersRoutes = true;

    /**
     * Indicates if Instrument migrations should be ran.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * The document model that should be used by Instrument.
     *
     * @var string
     */
    public static $documentModel = 'StarfolkSoftware\\Instrument\\Document';

    /**
     * Indicates if Instrument should support teams.
     *
     * @var bool
     */
    public static $supportsTeams = false;

    /**
     * The team model that should be used by Instrument.
     *
     * @var string
     */
    public static $teamModel;

    /**
     * Get the name of the document model used by the application.
     *
     * @return string
     */
    public static function teamModel()
    {
        return static::$teamModel;
    }

    /**
     * Specify the team model that should be used by Instrument.
     *
     * @param  string  $model
     * @return static
     */
    public static function useTeamModel(string $model)
    {
        static::$teamModel = $model;

        return new static();
    }

    /**
     * Get a new instance of the team model.
     *
     * @return mixed
     */
    public static function newTeamModel()
    {
        $model = static::teamModel();

        return new $model();
    }

    /**
     * Find a team instance by the given ID.
     *
     * @param  mixed  $id
     * @return mixed
     */
    public static function findTeamByIdOrFail($id)
    {
        return static::newTeamModel()->whereId($id)->firstOrFail();
    }

    /**
     * Get the name of the document model used by the application.
     *
     * @return string
     */
    public static function documentModel()
    {
        return static::$documentModel;
    }

    /**
     * Get a new instance of the document model.
     *
     * @return mixed
     */
    public static function newDocumentModel()
    {
        $model = static::documentModel();

        return new $model();
    }

    /**
     * Specify the document model that should be used by Instrument.
     *
     * @param  string  $model
     * @return static
     */
    public static function useDocumentModel(string $model)
    {
        static::$documentModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create documentes.
     *
     * @param  string  $class
     * @return void
     */
    public static function createDocumentsUsing(string $class)
    {
        app()->singleton(CreatesDocuments::class, $class);
    }

    /**
     * Register a class / callback that should be used to update documentes.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateDocumentsUsing(string $class)
    {
        app()->singleton(UpdatesDocuments::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete documentes.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteDocumentsUsing(string $class)
    {
        app()->singleton(DeletesDocuments::class, $class);
    }

    /**
     * Configure Instrument to not register its routes.
     *
     * @return static
     */
    public static function ignoreRoutes()
    {
        static::$registersRoutes = false;

        return new static();
    }

    /**
     * Configure Instrument to not run its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;

        return new static();
    }

    /**
     * Configure Instrument to support multiple teams.
     *
     * @param  bool  $value
     * @return static
     */
    public static function supportsTeams(bool $value = true)
    {
        static::$supportsTeams = $value;

        return new static();
    }

    /**
     * Get a completion redirect path for a specific feature.
     *
     * @param  string  $redirect
     * @return string
     */
    public static function redirects(string $redirect, $default = null)
    {
        return config('instrument.redirects.'.$redirect) ?? $default ?? '/';
    }
}
