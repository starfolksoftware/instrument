<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    protected $model = Tax::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['normal', 'fixed']),
            'name' => $this->faker->word(),
            'rate' => 7.5,
        ];
    }
}
