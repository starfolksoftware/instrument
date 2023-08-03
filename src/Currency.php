<?php

namespace Instrument;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class Currency extends Model
{
    /**
     * Get the team that owns the currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Instrument::teamModel(), 'team_id');
    }

    /**
     * Get all attached models of the given class to the currency.
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany(
            $class,
            'currensable',
            'currensables',
            'currency_id',
            'currensable_id',
            'id',
            'id'
        );
    }
}
