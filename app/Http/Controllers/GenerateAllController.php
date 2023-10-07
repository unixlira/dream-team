<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\TeamGame;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;

class GenerateAllController extends Controller
{
    public function generate()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Realizar o truncamento das tabelas
        PlayerTeam::truncate();
        TeamGame::truncate();
        Game::truncate();
        Team::truncate();
        Player::truncate();
        // Ativar restrições de chave estrangeira novamente
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Crie 10 times fictícios
        $teams = Team::factory(5)
                     ->create();

        // Crie 25 jogadores com diferentes níveis de habilidade
        $players = Player::factory()
                         ->count(25)
                         ->state(new Sequence(
                             ['skill_level' => 1],
                             ['skill_level' => 2],
                             ['skill_level' => 3],
                             ['skill_level' => 4],
                             ['skill_level' => 5]
                         ))
                         ->create();

        // Shuffle the player IDs to distribute them evenly among teams
        $shuffledPlayerIds = $players->shuffle()
                                     ->pluck('id')
                                     ->toArray();

        // Create PlayerTeam associations by distributing players evenly among teams
        $teamCount = count($teams);
        for ($i = 0; $i < 25; $i++) {
            $teamId = $teams[$i % $teamCount]->id;
            PlayerTeam::create([
                'player_id' => $shuffledPlayerIds[$i],
                'team_id'   => $teamId,
            ]);
        }

        // Crie 10 jogos fictícios, atribuindo times aleatoriamente
        Game::factory(10)
            ->create()
            ->each(function ($game) use ($teams) {
                // Associe dois times aleatórios a cada jogo
                $randomTeams = $teams->random(2)
                                     ->pluck('id')
                                     ->toArray();

                // Crie tuplas na tabela pivot (team_games) para associar times aos jogos
                TeamGame::create([
                    'game_id' => $game->id,
                    'team_id' => $randomTeams[0],
                ]);

                TeamGame::create([
                    'game_id' => $game->id,
                    'team_id' => $randomTeams[1],
                ]);

                // Atualize o game para armazenar os IDs dos times (opcional)
                $game->update([
                    'team_a_id' => $randomTeams[0],
                    'team_b_id' => $randomTeams[1],
                ]);
            });

        return redirect()->route('admin.game.index');
    }
}
