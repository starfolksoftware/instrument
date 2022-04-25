<?php

namespace StarfolkSoftware\Instrument;

trait TeamHasInstruments
{
    /**
     * Get the documents for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Instrument::$documentModel, 'team_id');
    }

    /**
     * Get the accounts for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Instrument::$accountModel, 'team_id');
    }

    /**
     * Get the transactions for the team.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Instrument::$transactionModel, 'team_id');
    }
}
