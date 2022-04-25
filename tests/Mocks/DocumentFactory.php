<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;
use StarfolkSoftware\Instrument\Instrument;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition()
    {
        $defs = [
            'parent_id' => null,
            'number' => $this->faker->uuid,
            'order_number' => $this->faker->uuid,
            'state' => $this->faker->randomElement(['draft', 'sent', 'received', 'partial', 'paid', 'cancelled']),
            'type' => $this->faker->randomElement(['invoice', 'order', 'credit_note', 'debit_note']),
            'issued_at' => now(),
            'due_at' => now()->addDays(1),
            'items' => [
                [
                    'description' => $this->faker->sentence,
                    'quantity' => $this->faker->randomFloat(2, 1, 100),
                    'unit_price' => $this->faker->randomFloat(2, 1, 100),
                    'currency_code' => $this->faker->randomElement(['EUR', 'USD', 'GBP']),
                    'tax_rate' => $this->faker->randomFloat(2, 1, 5),
                    'tax_amount' => $this->faker->randomFloat(2, 1, 100),
                    'discount_rate' => $this->faker->randomFloat(2, 1, 5),
                    'discount_amount' => $this->faker->randomFloat(2, 1, 100),
                    'total' => $this->faker->randomFloat(2, 1, 100),
                ],
            ],
            'totals' => [
                'subtotal' => $this->faker->randomFloat(2, 1, 100),
                'discount' => $this->faker->randomFloat(2, 1, 100),
                'tax' => $this->faker->randomFloat(2, 1, 100),
                'total' => $this->faker->randomFloat(2, 1, 100),
            ],
        ];

        if (Instrument::$supportsTeams) {
            $defs['team_id'] = 1;
        }

        return $defs;
    }
}
