<?php

namespace Database\Factories\Admon;

use App\Models\Admon\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admon\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $module = Module::factory()->create();

        return [
            'name' => $this->faker->word,
            'module_id' => Module::factory(),
        ];
    }
}
