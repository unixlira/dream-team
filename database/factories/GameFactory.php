<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        return [
            'public_id' => $this->faker->uuid,
            'team_a_id' => Team::factory()->create()->id,
            'team_b_id' => Team::factory()->create()->id,
            'game_at'   => $this->faker->dateTimeBetween('now', '+1 day'),
        ];
    }
}

