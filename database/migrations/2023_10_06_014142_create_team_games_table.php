<?php


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_games', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id', 36)
                  ->default(Str::uuid());
            $table->unsignedBigInteger('game_id')
                ->index();
            $table->unsignedBigInteger('team_id')
                ->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('game_id')
                ->references('id')
                ->on('games');

            $table->foreign('team_id')
                ->references('id')
                ->on('teams');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_games');
    }
};
