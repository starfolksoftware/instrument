<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use StarfolkSoftware\Instrument\Instrument;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $defs = [
            'account_id' => null,
            'document_id' => null,
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'payment_method' =>  $this->faker->randomElement(['cash', 'credit_card', 'debit_card']),
            'paid_at' => now(),
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
