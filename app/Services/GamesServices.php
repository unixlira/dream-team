<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\GameResource;

class GamesServices
{
    public function index()
    {
        $games = Game::with('teamA.players', 'teamB.players')
                     ->get();

        $gamesResource = GameResource::collection($games);

        return view('web.game.index', compact('gamesResource'));
    }

    public function create()
    {
        try {

            $teams = Team::all();

            if($teams->count() < 2){
                session()->flash('error', 'Necessário 2 times para gerar partida');

                return redirect()->route('admin.game.index');
            }

            $shuffledTeams = $teams->shuffle();

            $usedTeams = [];

            foreach ($shuffledTeams as $teamA) {
                foreach ($shuffledTeams as $teamB) {
                    if ($teamA->id !== $teamB->id && !in_array([$teamA->id, $teamB->id], $usedTeams) && !in_array([$teamB->id, $teamA->id], $usedTeams)) {
                        $usedTeams[] = [$teamA->id, $teamB->id];
                        $gameTime = now()->addMinutes(105);
                        Game::create([
                            'team_a_id' => $teamA->id,
                            'team_b_id' => $teamB->id,
                            'game_at' => $gameTime,
                        ]);
                    }
                }
            }

            session()->flash('success', 'Partidas criadas com sucesso');

            return redirect()->route('admin.game.index');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Partidas: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao criar Partidas: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($publicId)
    {
        try {

            $games = Game::where('public_id', $publicId)
                          ->first();

            $games->delete();

            session()->flash('error', 'Partida excluido com sucesso');


            return redirect()->route('admin.game.index');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir Partida: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao excluir Partida: ' . $e->getMessage()], 500);
        }    }
}
