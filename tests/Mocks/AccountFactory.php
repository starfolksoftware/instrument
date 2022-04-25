<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use StarfolkSoftware\Instrument\Instrument;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        $defs = [
            'name' => $this->faker->name,
            'number' => $this->faker->uuid,
            'opening_balance' => $this->faker->randomFloat(2, 0, 100),
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
