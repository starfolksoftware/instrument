<?php

namespace Instrument;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

final class Instrument
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
     * Indicates if Instrument supports soft deletes.
     */
    public static bool $softDeletes = true;

    /**
     * The contact model that should be used by Ally.
     *
     * @var string
     */
    public static $contactModel = 'App\\Models\\Contact';

    /**
     * The tax model that should be used by Levy.
     *
     * @var string
     */
    public static $taxModel = 'App\\Models\\Tax';

    /**
     * The currency model that should be used by Tender.
     */
    public static string $currencyModel = 'App\\Models\\Currency';

    /**
     * The document model that should be used by Instrument.
     *
     * @var string
     */
    public static $documentModel = 'App\\Models\\Document';

    /**
     * The account model that should be used by Instrument.
     *
     * @var string
     */
    public static $accountModel = 'App\\Models\\Account';

    /**
     * The payment method model that should be used by Instrument.
     *
     * @var string
     */
    public static $paymentMethodModel = 'App\\Models\\PaymentMethod';

    /**
     * The transaction model that should be used by Instrument.
     *
     * @var string
     */
    public static $transactionModel = 'App\\Models\\Transaction';

    /**
     * The report model that should be used by Instrument.
     *
     * @var string
     */
    public static $reportModel = 'App\\Models\\Report';

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
     * Get the name of the team model used by the application.
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
     * Get the name of the contact model used by the application.
     *
     * @return string
     */
    public static function contactModel()
    {
        return static::$contactModel;
    }

    /**
     * Get a new instance of the contact model.
     *
     * @return mixed
     */
    public static function newContactModel()
    {
        $model = static::contactModel();

        return new $model();
    }

    /**
     * Specify the contact model that should be used by Ally.
     *
     * @param  string  $model
     * @return static
     */
    public static function useContactModel(string $model)
    {
        static::$contactModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create Contacts.
     *
     * @param  string  $class
     * @return void
     */
    public static function createContactsUsing(string $class)
    {
        app()->singleton(Contracts\CreatesContacts::class, $class);
    }

    /**
     * Register a class / callback that should be used to update Contacts.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateContactsUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesContacts::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete Contacts.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteContactsUsing(string $class)
    {
        app()->singleton(Contracts\DeletesContacts::class, $class);
    }

    /**
     * Get the name of the tax model used by the application.
     *
     * @return string
     */
    public static function taxModel()
    {
        return static::$taxModel;
    }

    /**
     * Get a new instance of the tax model.
     *
     * @return mixed
     */
    public static function newTaxModel()
    {
        $model = static::taxModel();

        return new $model();
    }

    /**
     * Specify the tax model that should be used by Levy.
     *
     * @param  string  $model
     * @return static
     */
    public static function useTaxModel(string $model)
    {
        static::$taxModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create taxes.
     *
     * @param  string  $class
     * @return void
     */
    public static function createTaxesUsing(string $class)
    {
        app()->singleton(Contracts\CreatesTaxes::class, $class);
    }

    /**
     * Register a class / callback that should be used to update taxes.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateTaxesUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesTaxes::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete taxes.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteTaxesUsing(string $class)
    {
        app()->singleton(Contracts\DeletesTaxes::class, $class);
    }

    /**
     * Get the name of the currency model used by the application.
     */
    public static function currencyModel(): string
    {
        return static::$currencyModel;
    }

    /**
     * Get a new instance of the currency model.
     */
    public static function newCurrencyModel(): Model
    {
        $model = static::currencyModel();

        return new $model();
    }

    /**
     * Specify the currency model that should be used by Tender.
     */
    public static function useCurrencyModel(string $model): static
    {
        static::$currencyModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create Currencies.
     */
    public static function createCurrenciesUsing(string $class): void
    {
        app()->singleton(Contracts\CreatesCurrencies::class, $class);
    }

    /**
     * Register a class / callback that should be used to update Currencies.
     */
    public static function updateCurrenciesUsing(string $class): void
    {
        app()->singleton(Contracts\UpdatesCurrencies::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete Currencies.
     */
    public static function deleteCurrenciesUsing(string $class): void
    {
        app()->singleton(Contracts\DeletesCurrencies::class, $class);
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
     * Get the name of the account model used by the application.
     *
     * @return string
     */
    public static function accountModel()
    {
        return static::$accountModel;
    }

    /**
     * Get a new instance of the account model.
     *
     * @return mixed
     */
    public static function newAccountModel()
    {
        $model = static::accountModel();

        return new $model();
    }

    /**
     * Specify the account model that should be used by Instrument.
     *
     * @param  string  $model
     * @return static
     */
    public static function useAccountModel(string $model)
    {
        static::$accountModel = $model;

        return new static();
    }

    /**
     * Get the name of the transaction model used by the application.
     *
     * @return string
     */
    public static function transactionModel()
    {
        return static::$transactionModel;
    }

    /**
     * Get a new instance of the transaction model.
     *
     * @return mixed
     */
    public static function newTransactionModel()
    {
        $model = static::transactionModel();

        return new $model();
    }

    /**
     * Specify the transaction model that should be used by Instrument.
     *
     * @param  string  $model
     * @return static
     */
    public static function useTransactionModel(string $model)
    {
        static::$transactionModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create documents.
     *
     * @param  string  $class
     * @return void
     */
    public static function createDocumentsUsing(string $class)
    {
        app()->singleton(Contracts\CreatesDocuments::class, $class);
    }

    /**
     * Register a class / callback that should be used to update documents.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateDocumentsUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesDocuments::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete documents.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteDocumentsUsing(string $class)
    {
        app()->singleton(Contracts\DeletesDocuments::class, $class);
    }

    /**
     * Register a class / callback that should be used to create accounts.
     *
     * @param  string  $class
     * @return void
     */
    public static function createAccountsUsing(string $class)
    {
        app()->singleton(Contracts\CreatesAccounts::class, $class);
    }

    /**
     * Register a class / callback that should be used to update accounts.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateAccountsUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesAccounts::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete accounts.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteAccountsUsing(string $class)
    {
        app()->singleton(Contracts\DeletesAccounts::class, $class);
    }

    /**
     * Register a class / callback that should be used to create transactions.
     *
     * @param  string  $class
     * @return void
     */
    public static function createTransactionsUsing(string $class)
    {
        app()->singleton(Contracts\CreatesTransactions::class, $class);
    }

    /**
     * Register a class / callback that should be used to update transactions.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateTransactionsUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesTransactions::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete transactions.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteTransactionsUsing(string $class)
    {
        app()->singleton(Contracts\DeletesTransactions::class, $class);
    }

    /**
     * Get the name of the payment method model used by the application.
     *
     * @return string
     */
    public static function paymentMethodModel()
    {
        return static::$paymentMethodModel;
    }

    /**
     * Get a new instance of the payment method model.
     *
     * @return mixed
     */
    public static function newPaymentMethodModel()
    {
        $model = static::paymentMethodModel();

        return new $model();
    }

    /**
     * Specify the payment method model that should be used by Instrument.
     *
     * @param  string  $model
     * @return static
     */
    public static function usePaymentMethodModel(string $model)
    {
        static::$paymentMethodModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create payment methods.
     *
     * @param  string  $class
     * @return void
     */
    public static function createPaymentMethodsUsing(string $class)
    {
        app()->singleton(Contracts\CreatesPaymentMethods::class, $class);
    }

    /**
     * Register a class / callback that should be used to update payment methods.
     *
     * @param  string  $class
     * @return void
     */
    public static function updatePaymentMethodsUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesPaymentMethods::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete payment methods.
     *
     * @param  string  $class
     * @return void
     */
    public static function deletePaymentMethodsUsing(string $class)
    {
        app()->singleton(Contracts\DeletesPaymentMethods::class, $class);
    }

    /**
     * Get the name of the report model used by the application.
     *
     * @return string
     */
    public static function reportModel()
    {
        return static::$reportModel;
    }

    /**
     * Get a new instance of the report model.
     *
     * @return mixed
     */
    public static function newReportModel()
    {
        $model = static::reportModel();

        return new $model();
    }

    /**
     * Specify the report model that should be used by Instrument.
     *
     * @param  string  $model
     * @return static
     */
    public static function useReportModel(string $model)
    {
        static::$reportModel = $model;

        return new static();
    }

    /**
     * Register a class / callback that should be used to create reports.
     *
     * @param  string  $class
     * @return void
     */
    public static function createReportsUsing(string $class)
    {
        app()->singleton(Contracts\CreatesReports::class, $class);
    }

    /**
     * Register a class / callback that should be used to update reports.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateReportsUsing(string $class)
    {
        app()->singleton(Contracts\UpdatesReports::class, $class);
    }

    /**
     * Register a class / callback that should be used to delete reports.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteReportsUsing(string $class)
    {
        app()->singleton(Contracts\DeletesReports::class, $class);
    }

    public static function money(float $amount, string $currency = 'NGN')
    {
        return (new NumberFormatter("en_NG", NumberFormatter::CURRENCY))->formatCurrency($amount, $currency);
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
     * Configure Instrument to support soft deletes.
     */
    public static function supportsSoftDeletes(bool $value = true)
    {
        static::$softDeletes = $value;

        return new static();
    }

    /**
     * Get a completion redirect path for a specific feature.
     *
     * @param  string  $type
     * @param  string  $redirect
     * @return string
     */
    public static function redirects(string $type, string $redirect, $default = null)
    {
        return config("instrument.redirects.{$type}.{$redirect}") ?? $default ?? '/';
    }
}
