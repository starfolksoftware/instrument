<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Document;
use App\Models\Tax;
use App\Models\Transaction;
use Illuminate\Support\ServiceProvider;
use StarfolkSoftware\Instrument\Instrument;

class InstrumentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Instrument::useDocumentModel(Document::class);

        Instrument::useAccountModel(Account::class);

        Instrument::useTaxModel(Tax::class);

        Instrument::useCurrencyModel(Currency::class);

        Instrument::useTransactionModel(Transaction::class);
    }
}