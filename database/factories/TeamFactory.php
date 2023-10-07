<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'public_id'   => $this->faker->uuid,
            'name'        => $this->faker->company,
            'max_players' => $this->faker->numberBetween(1, 6),
        ];
    }
}

