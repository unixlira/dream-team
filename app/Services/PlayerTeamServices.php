<?php

namespace App\Services;

use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TeamResource;

class PlayerTeamServices
{
    public function index()
    {
        $playersTeams = PlayerTeam::with('team.players')
                                   ->select('team_id', DB::raw('count(id) as total_players'), DB::raw('max(public_id) as public_id'))
                                   ->groupBy('team_id')
                                   ->paginate(5);

        $playersTeamsResource = PlayerResource::collection($playersTeams);

        return view('web.player-team.index', compact('playersTeamsResource'));
    }

    public function store($request)
    {
        try {

            $data = $request->only(
                'name',
                'max_players'
            );

            Team::create($data);

            session()->flash('success', 'Time criado com sucesso');

            return redirect()->route('admin.team.index');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Time: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao criar Time: ' . $e->getMessage()], 500);
        }
    }

    public function show($publicId)
    {
        $playersTeams = PlayerTeam::with('team.players')
                                  ->where('public_id', $publicId)
                                  ->first();

        $playersTeamsResource = PlayerResource::make($playersTeams);

        return view('web.player-team.show', compact('playersTeamsResource'));
    }

    public function destroy($publicId)
    {
        try {

            $team = PlayerTeam::where('public_id', $publicId)
                        ->first();

            $team->delete();

            session()->flash('error', 'Time excluido com sucesso');


            return redirect()->route('admin.team.index');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir time: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao excluir time: ' . $e->getMessage()], 500);
        }
    }

    public function shuffle()
    {
        PlayerTeam::truncate();

        $teams = Team::all();

        if ($teams->count() < 2) {
            return redirect()->route('admin.player-team.index')
                ->with('error', 'Não é possível realizar o sorteio. Cadastre pelo menos 2 times.');
        }

        $confirmedPlayers = Player::where('is_presence', true)
                                  ->orderBy('skill_level', 'desc')
                                  ->get();

        $shuffledPlayers = $confirmedPlayers->shuffle();

        $goalkeeperAssigned = [];

        foreach ($teams as $team) {
            $numberOfPlayersPerTeam = $team->max_players;

            if ($confirmedPlayers->count() < ($numberOfPlayersPerTeam * 2)) {
                return redirect()->route('admin.player-team.index')
                    ->with('error', 'Não é possível realizar o sorteio. O número de jogadores confirmados é insuficiente.');
            }

            $selectedPlayers = collect([]);

            if (!in_array($team->id, $goalkeeperAssigned)) {
                $selectedGoalkeeper = $shuffledPlayers->where('is_goalkeeper', true)->first();
                if ($selectedGoalkeeper) {
                    $selectedPlayers->push($selectedGoalkeeper);
                    $goalkeeperAssigned[] = $team->id;
                }
            }

            $remainingPlayersCount = $numberOfPlayersPerTeam - $selectedPlayers->count();
            $remainingPlayers = $shuffledPlayers->where('is_goalkeeper', false)->take($remainingPlayersCount);
            $selectedPlayers = $selectedPlayers->concat($remainingPlayers);

            foreach ($selectedPlayers as $player) {
                PlayerTeam::create([
                    'player_id' => $player->id,
                    'team_id'   => $team->id,
                ]);
            }

            $shuffledPlayers = $shuffledPlayers->diff($selectedPlayers);
        }

        $remainingPlayersCount = $shuffledPlayers->count();

        while ($remainingPlayersCount > 0) {
            $playersPerReserveTeam = min($remainingPlayersCount, 6); // Máximo de 6 jogadores por time reserva

            $reserveTeam = Team::create([
                'name' => 'Time Reserva ' . (count($teams) + 1),
                'max_players' => $playersPerReserveTeam,
            ]);

            if ($shuffledPlayers->where('is_goalkeeper', true)->count() > 0) {
                $selectedGoalkeeper = $shuffledPlayers->where('is_goalkeeper', true)->first();
                PlayerTeam::create([
                    'player_id' => $selectedGoalkeeper->id,
                    'team_id' => $reserveTeam->id,
                ]);
                $shuffledPlayers = $shuffledPlayers->diff([$selectedGoalkeeper]);
            }

            $selectedReservePlayers = $shuffledPlayers->take($playersPerReserveTeam);
            $shuffledPlayers = $shuffledPlayers->diff($selectedReservePlayers);

            foreach ($selectedReservePlayers as $player) {
                PlayerTeam::create([
                    'player_id' => $player->id,
                    'team_id' => $reserveTeam->id,
                ]);
            }

            $remainingPlayersCount = $shuffledPlayers->count();
        }

        return redirect()->route('admin.player-team.index');
    }

}
