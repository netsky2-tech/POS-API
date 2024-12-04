<?php

namespace Database\Factories\Admon;

use App\Models\Admon\Permission;
use App\Models\Admon\Role;
use App\Models\Admon\Action;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::factory(),
            'action_id' => Action::factory(),
            'created_by' => $this->faker->name,
            'modified_by' => $this->faker->name,
        ];
    }
}
