<?php

namespace Database\Factories\Admon;

use App\Models\Admon\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admon\Action>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $menu = Menu::factory()->create();

        return [
            'name' => $this->faker->word,
            'menu_id' => $menu->id
        ];
    }
}
