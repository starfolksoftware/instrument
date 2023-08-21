<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use Instrument\Instrument;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition()
    {
        $defs = [
            'name' => $this->faker->name,
            'meta' => [
                'foo' => $this->faker->word,
                'bar' => $this->faker->word,
            ],
        ];

        if (Instrument::$supportsTeams) {
            $defs['team_id'] = 1;
        }

        return $defs;
    }
}
