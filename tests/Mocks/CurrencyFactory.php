<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->currencyCode(),
            'rate' => $this->faker->randomDigitNotZero(),
        ];
    }
}
