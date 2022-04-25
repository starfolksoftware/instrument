<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Document;
use App\Models\Transaction;
use Illuminate\Support\ServiceProvider;
use StarfolkSoftware\Instrument\Actions\CreateDocument;
use StarfolkSoftware\Instrument\Actions\DeleteDocument;
use StarfolkSoftware\Instrument\Actions\UpdateDocument;
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
        Instrument::createDocumentsUsing(CreateDocument::class);

        Instrument::updateDocumentsUsing(UpdateDocument::class);

        Instrument::deleteDocumentsUsing(DeleteDocument::class);

        Instrument::useDocumentModel(Document::class);

        Instrument::useAccountModel(Account::class);

        Instrument::useTransactionModel(Transaction::class);
    }
}