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

    public function create()
    {
        return view('web.team.create');
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
        $team = PlayerTeam::where('public_id', $publicId)
                    ->first();

        $team = TeamResource::make($team);

        return view('web.team.show', compact('team'));
    }

    public function edit($publicId)
    {
        $team = PlayerTeam::where('public_id', $publicId)
                    ->first();

        $team = TeamResource::make($team);

        return view('web.team.edit', compact('team'));
    }

    public function update($request, $publicId)
    {
        try {
            $data = $request->all();

            $team = PlayerTeam::where('public_id', $publicId)
                        ->first();

            $team->update($data);

            session()->flash('success', 'Time atualizado com sucesso');


            return redirect()->route('admin.team.index');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar time: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar time: ' . $e->getMessage()], 500);
        }
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

        if (count($teams) < 2) {
            return redirect()->route('admin.player-team.index')
                             ->with('error', 'Não é possível realizar o sorteio. Cadastre pelo menos 2 times.');
        }

        $confirmedPlayers = Player::where('is_presence', true)
                                  ->orderByDesc('skill_level')
                                  ->get();

        $goalkeeperAssigned = [];

        foreach ($teams as $team) {
            $numberOfPlayersPerTeam = $team->max_players;

            if (count($confirmedPlayers) < ($numberOfPlayersPerTeam * 2)) {
                return redirect()->route('admin.player-team.index')
                                 ->with('error', 'Não é possível realizar o sorteio. O número de jogadores confirmados é insuficiente.');
            }

            $selectedPlayers = collect([]);

            if (!in_array($team->id, $goalkeeperAssigned)) {
                $selectedGoalkeeper = $confirmedPlayers->where('is_goalkeeper', true)
                                                       ->first();
                if ($selectedGoalkeeper) {
                    $selectedPlayers->push($selectedGoalkeeper);
                    $goalkeeperAssigned[] = $team->id;
                }
            }

            $remainingPlayersCount = $numberOfPlayersPerTeam - $selectedPlayers->count();
            $remainingPlayers      = $confirmedPlayers->where('is_goalkeeper', false)->take($remainingPlayersCount);
            $selectedPlayers       = $selectedPlayers->concat($remainingPlayers);

            foreach ($selectedPlayers as $player) {
                PlayerTeam::create([
                    'player_id' => $player->id,
                    'team_id'   => $team->id,
                ]);
            }

            $confirmedPlayers = $confirmedPlayers->diff($selectedPlayers);
        }

        $remainingPlayersCount = count($confirmedPlayers);

        while ($remainingPlayersCount > 0) {
            $playersPerReserveTeam = min($remainingPlayersCount, 6);

            $reserveTeam = Team::create([
                'name'        => 'Time Reserva ' . (count($teams) + 1),
                'max_players' => $playersPerReserveTeam,
            ]);

            $selectedGoalkeeper = $confirmedPlayers->where('is_goalkeeper', true)->first();
            if ($selectedGoalkeeper) {
                PlayerTeam::create([
                    'player_id' => $selectedGoalkeeper->id,
                    'team_id'   => $reserveTeam->id,
                ]);
                $confirmedPlayers = $confirmedPlayers->diff([$selectedGoalkeeper]);
            }

            $selectedReservePlayers = $confirmedPlayers->take($playersPerReserveTeam);
            $confirmedPlayers       = $confirmedPlayers->diff($selectedReservePlayers);

            foreach ($selectedReservePlayers as $player) {
                PlayerTeam::create([
                    'player_id' => $player->id,
                    'team_id'   => $reserveTeam->id,
                ]);
            }

            $remainingPlayersCount = count($confirmedPlayers);
        }

        return redirect()->route('admin.player-team.index');
    }


}
