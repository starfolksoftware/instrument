<?php

namespace Instrument;

trait TeamHasInstruments
{
    /**
     * Get the currencies associated with the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currencies()
    {
        return $this->hasMany(Instrument::currencyModel(), 'team_id');
    }

    /**
     * Get the contacts associated with the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Instrument::contactModel(), 'team_id');
    }

    /**
     * Get the taxes associated with the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxes()
    {
        return $this->hasMany(Instrument::taxModel(), 'team_id');
    }

    /**
     * Get the documents for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Instrument::documentModel(), 'team_id');
    }

    /**
     * Get the accounts for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Instrument::accountModel(), 'team_id');
    }

    /**
     * Get the transactions for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Instrument::transactionModel(), 'team_id');
    }

    /**
     * Get the payment methods for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods()
    {
        return $this->hasMany(Instrument::paymentMethodModel(), 'team_id');
    }

    /**
     * Get the reports for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Instrument::reportModel(), 'team_id');
    }
}
