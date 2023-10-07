<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id', 36)
                  ->default(Str::uuid());
            $table->unsignedBigInteger('team_a_id')
                  ->index();
            $table->unsignedBigInteger('team_b_id')
                  ->index();
            $table->timestamp('game_at')
                  ->index();
            $table->timestamps();

            $table->foreign('team_a_id')
                ->references('id')
                ->on('teams');

            $table->foreign('team_b_id')
                ->references('id')
                ->on('teams');
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
