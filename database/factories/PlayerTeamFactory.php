<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerTeamFactory extends Factory
{
    protected $model = PlayerTeam::class;

    public function definition()
    {
        return [
            'public_id' => $this->faker->uuid,
            'player_id' => Player::inRandomOrder()->first()->id,
            'team_id'   => Team::inRandomOrder()->first()->id,
        ];
    }
}

