<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up()
    {
        Schema::table('player_teams', function (Blueprint $table) {
            $table->boolean('reset')
                  ->default(false)
                  ->after('team_id');
        });
    }

    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('reset');
        });
    }
};
