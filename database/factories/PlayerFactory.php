<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition()
    {
        return [
            'public_id'     => $this->faker->uuid,
            'name'          => $this->faker->name,
            'skill_level'   => $this->faker->numberBetween(1, 5),
            'is_goalkeeper' => $this->faker->boolean(20), // 10% chance de ser true
            'is_presence'   => $this->faker->boolean(50), // 50% chance de ser true
        ];
    }
}

