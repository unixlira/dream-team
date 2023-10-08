<?php

namespace App\Providers;

use App\Models\Player;
use App\Observers\PlayerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Player::observe(PlayerObserver::class);
    }
}
