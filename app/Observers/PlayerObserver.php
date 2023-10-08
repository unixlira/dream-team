<?php

namespace App\Observers;

use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PlayerObserver
{
    public function updated(Player $player): void
    {
        DB::update('update player_teams set reset = 1 where 1=1');
    }
}
