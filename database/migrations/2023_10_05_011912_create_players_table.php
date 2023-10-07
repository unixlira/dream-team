<?php


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_id', 36)
                  ->default(Str::uuid());
            $table->string('name')
                  ->index();
            $table->integer('skill_level')
                  ->unsigned()
                  ->index();
            $table->boolean('is_goalkeeper')
                  ->default(0)
                  ->index();
            $table->boolean('is_presence')
                  ->default(0)
                  ->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
}

