<?php

namespace StarfolkSoftware\Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['customer', 'supplier']),
            'name' => $this->faker->name(),
            'meta' => [
                'email' => 'test@example.org',
            ],
        ];
    }
}
