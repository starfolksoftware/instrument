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
        return $this->hasMany(Instrument::$documentModel);
    }
}