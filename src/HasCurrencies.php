<?php

namespace Instrument;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as BaseCollection;

trait HasCurrencies
{
    /**
     * Get all attached currencies to the model.
     */
    public function currencies(): MorphToMany
    {
        return $this->morphToMany(
            Instrument::currencyModel(),
            'currensable',
            'currensables',
            'currensable_id',
            'currency_id'
        )->withTimestamps();
    }

    /**
     * Scope query with all the given currencies.
     */
    public function scopeWithAllCurrencies(Builder $builder, BaseCollection|array|int|Model|Collection|null $currencies): Builder
    {
        $currencies = $this->prepareCurrencyIds($currencies);

        collect($currencies)->each(function ($currency) use ($builder) {
            $builder->whereHas('currencies', function (Builder $builder) use ($currency) {
                return $builder->where('currencies.id', $currency);
            });
        });

        return $builder;
    }

    /**
     * Scope query with any of the given currencies.
     */
    public function scopeWithAnyCurrencies(Builder $builder, BaseCollection|array|int|Model|Collection|null $currencies): Builder
    {
        $currencies = $this->prepareCurrencyIds($currencies);

        return $builder->whereHas('currencies', function (Builder $builder) use ($currencies) {
            $builder->whereIn('currencies.id', $currencies);
        });
    }

    /**
     * Scope query without any of the given currencies.
     */
    public function scopeWithoutCurrencies(Builder $builder, BaseCollection|array|int|Model|Collection|null $currencies): Builder
    {
        $currencies = $this->prepareCurrencyIds($currencies);

        return $builder->whereDoesntHave('currencies', function (Builder $builder) use ($currencies) {
            $builder->whereIn('currencies.id', $currencies);
        });
    }

    /**
     * Scope query without any currencies.
     */
    public function scopeWithoutAnyCurrencies(Builder $builder): Builder
    {
        return $builder->doesntHave('currencies');
    }

    /**
     * Determine if the model has any of the given currencies.
     */
    public function hasCurrencies(BaseCollection|array|int|Model|Collection|null $currencies): bool
    {
        $currencies = $this->prepareCurrencyIds($currencies);

        return ! $this->currencies->pluck('id')->intersect($currencies)->isEmpty();
    }

    /**
     * Determine if the model has all of the given currencies.
     */
    public function hasAllCurrencies(BaseCollection|array|int|Model|Collection|null $currencies): bool
    {
        $currencies = $this->prepareCurrencyIds($currencies);

        return collect($currencies)->diff($this->currencies->pluck('id'))->isEmpty();
    }

    /**
     * Sync model currencies.
     */
    public function syncCurrencies(BaseCollection|array|int|Model|Collection|null $currencies, bool $detaching = true): static
    {
        // Find currencies
        $currencies = $this->prepareCurrencyIds($currencies);

        // Sync model currencies
        $this->currencies()->sync($currencies, $detaching);

        return $this;
    }

    /**
     * Attach model currencies.
     */
    public function attachCurrencies(BaseCollection|array|int|Model|Collection|null $currencies): static
    {
        return $this->syncCurrencies($currencies, false);
    }

    /**
     * Detach model currencies.
     */
    public function detachCurrencies(BaseCollection|array|int|Model|Collection|null $currencies = null): static
    {
        $currencies = ! is_null($currencies) ? $this->prepareCurrencyIds($currencies) : null;

        // Sync model currencies
        $this->currencies()->detach($currencies);

        return $this;
    }

    /**
     * Prepare currency IDs.
     */
    protected function prepareCurrencyIds(BaseCollection|array|int|Model|Collection|null $currencies): array
    {
        // Convert collection to plain array
        if ($currencies instanceof BaseCollection && is_string($currencies->first())) {
            $currencies = $currencies->toArray();
        }

        // Find currencies by their ids
        if (is_numeric($currencies) || (is_array($currencies) && is_numeric(Arr::first($currencies)))) {
            return array_map('intval', (array) $currencies);
        }

        if ($currencies instanceof Model) {
            return [$currencies->getKey()];
        }

        if ($currencies instanceof Collection) {
            return $currencies->modelKeys();
        }

        if ($currencies instanceof BaseCollection) {
            return $currencies->toArray();
        }

        return (array) $currencies;
    }
}