<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->randomElement(['Alive', 'Dead', 'unknown']),
            'location' => $this->faker->randomElement(['Citadel of Ricks', 'Earth (Replacement Dimension)', 'Interdimensional Cable', 'unknown']),
            'last_episode' => $this->faker->randomElement(['Pickle Rick', 'A Rickle in Time', 'M. Night Shaym-Aliens!']),
            'species' => $this->faker->randomElement(['Human', 'Alien']),
            'origin' => $this->faker->randomElement(['Earth (C-137)', 'Earth (Replacement Dimension)', 'Abadango', 'unknown']),
        ];
    }
}
