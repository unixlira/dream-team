<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use App\Models\TeamGame;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamGameFactory extends Factory
{
    protected $model = TeamGame::class;

    public function definition()
    {
        return [
            'public_id' => $this->faker->uuid,
            'game_id'   => Game::inRandomOrder()->first()->id,
            'team_id'   => Team::inRandomOrder()->first()->id,
        ];
    }
}

