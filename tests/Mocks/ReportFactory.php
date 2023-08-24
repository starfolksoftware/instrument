<?php

namespace Instrument\Tests\Mocks;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition()
    {
        return [
            'type' => 'expense',
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'settings' => [
                'group' => 'category',
                'period' => 'monthly',
                'basis' => 'accrual',
            ],
        ];
    }
}
