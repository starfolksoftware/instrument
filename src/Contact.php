<?php

namespace StarfolkSoftware\Instrument;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class Contact extends Model
{
    /**
     * Get the team that owns the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Instrument::contactModel(), 'team_id');
    }

    /**
     * Get all attached models of the given class to the contact.
     *
     * @param string $class
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function entries(string $class): MorphToMany
    {
        return $this->morphedByMany(
            $class,
            'contactables',
            'contactabless',
            'contact_id',
            'contactables_id',
            'id',
            'id'
        );
    }

    /**
     * Scope query with the given type.
     */
    public function scopeOfType(Builder $query, array|string $type): void
    {
        if (is_array($type)) {
            $query->whereIn('type', $type);
        } else {
            $query->where('type', $type);
        }
    }
}
