<?php

namespace Database\Factories\Admon;

use App\Models\Admon\Role;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'created_by' => $this->faker->name,
            'modified_by' => $this->faker->name,
        ];
    }
}
