<?php

namespace Instrument;

use Illuminate\Database\Eloquent\Model;

abstract class Report extends Model
{
    /**
     * The team that owns the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Instrument::teamModel(), 'team_id');
    }
}
