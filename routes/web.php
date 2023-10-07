<?php

use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerTeamController;
use App\Http\Controllers\GenerateAllController;

Route::get('/', function () {
    return view('index');
});

Route::get('/admin/player-team/shuffle',[PlayerTeamController::class, 'shuffle'])
    ->name('admin.player-team.shuffle');

Route::prefix('admin')->group(function(){
    Route::resource('player',PlayerController::class)
          ->names('admin.player');
    Route::resource('team',TeamController::class)
         ->names('admin.team');
    Route::resource('game',GameController::class)
         ->names('admin.game');
    Route::resource('player-team',PlayerTeamController::class)
         ->names('admin.player-team');

});

Route::prefix('generate')->group(function(){
    Route::get('all',[GenerateAllController::class, 'generate'])
         ->name('generate.all');
});

Route::get('/pc', function () {

    $players = Player::factory(25)->create();

    return response()->json([
        'status' => 'success',
        'data'   =>  $players
    ]);
});

Route::get('/tc', function () {

    $teams = Team::factory(10)->create();

    return response()->json([
        'status' => 'success',
        'data'   =>  $teams
    ]);
});

Route::get('/rpt', function () {

    PlayerTeam::truncate();

    return response()->json([
        'status' => 'success'
    ]);
});

