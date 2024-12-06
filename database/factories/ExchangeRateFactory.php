<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\ExchangeRate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExchangeRate>
 */
class ExchangeRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $base_currency = Currency::factory()->create();
        $target_currency = Currency::factory()->create();

        return [
            'base_currency_id' => $base_currency->id,
            'target_currency_id' => $target_currency->id,
            'exchange_rate' => $this->faker->randomNumber(),
            'valid_from' => $this->faker->dateTime()
        ];
    }
}
