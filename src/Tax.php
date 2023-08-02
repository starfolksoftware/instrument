<?php

namespace StarfolkSoftware\Instrument;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class Tax extends Model
{
    /**
     * Get the team that owns the tax.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Instrument::taxModel(), 'team_id');
    }

    /**
     * Get all attached models of the given class to the category.
     *
     * @param string $class
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany($class, 'taxable', 'taxables', 'tax_id', 'taxable_id', 'id', 'id');
    }
}
