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

        $teams   = Team::all();
        $players = Player::where('is_presence', true)
                         ->get();

        $numberOfPlayersPerTeam = $teams->first()->max_players;

        $totalConfirmedPlayers = $players->count();

        if ($totalConfirmedPlayers < ($numberOfPlayersPerTeam * 2)) {
            return redirect()->route('admin.player-team.index')
                             ->with('error', 'Não é possível realizar o sorteio. O número de jogadores confirmados é insuficiente.');
        }

        $assignedPlayers = [];

        foreach ($teams as $team) {
            $numberOfPlayersPerTeam = $team->max_players;
            $goalkeeperAssigned = false;

            $availablePlayers = $players->filter(function ($player) use ($team, $assignedPlayers, &$goalkeeperAssigned) {

                $isGoalkeeper = $player->is_goalkeeper;

                if ($isGoalkeeper && $goalkeeperAssigned) {
                    return false;
                }

                if ($isGoalkeeper) {
                    $goalkeeperAssigned = true;
                }

                if (Arr::exists($assignedPlayers, $player->id)) {
                    return false;
                }

                return !$isGoalkeeper || $team->players->where('is_goalkeeper', true)->count() < 1;
            })->sortBy('skill_level');

            $shuffledPlayers = $availablePlayers->shuffle();

            $selectedPlayers = $shuffledPlayers->take($numberOfPlayersPerTeam);

            foreach ($selectedPlayers as $player) {
                PlayerTeam::create([
                    'player_id' => $player->id,
                    'team_id'   => $team->id,
                ]);

                $assignedPlayers[] = $player->id;
            }

            $players = $players->reject(function ($player) use ($assignedPlayers) {
                return in_array($player->id, $assignedPlayers);
            });
        }

        $teamsWithoutGoalkeeper = $teams->filter(function ($team) {
            return $team->players->where('is_goalkeeper', true)->count() < 1;
        });

        foreach ($teamsWithoutGoalkeeper as $team) {

            $availableGoalkeepers = $players->filter(function ($player) use ($assignedPlayers) {
                return !$player->is_goalkeeper && !in_array($player->id, $assignedPlayers);
            });

            if (!$availableGoalkeepers->isEmpty()) {

                $goalkeeper = $availableGoalkeepers->first();
                PlayerTeam::create([
                    'player_id' => $goalkeeper->id,
                    'team_id'   => $team->id,
                ]);

                $assignedPlayers[] = $goalkeeper->id;
            }
        }

        $teamNameSuffix = 1;
        while (!$players->isEmpty()) {
            $remainingPlayers = $players->splice(0, $numberOfPlayersPerTeam);

            $newTeamName = 'Time dos Remanescentes ' . $teamNameSuffix;

            while (Team::where('name', $newTeamName)->exists()) {
                $teamNameSuffix++;
                $newTeamName = 'Time dos Remanescentes ' . $teamNameSuffix;
            }

            $lastTeam = Team::create([
                'name' => $newTeamName,
                'max_players' => $numberOfPlayersPerTeam,
            ]);

            foreach ($remainingPlayers as $player) {
                PlayerTeam::create([
                    'player_id' => $player->id,
                    'team_id'   => $lastTeam->id,
                ]);

                $assignedPlayers[] = $player->id;
            }

            $teamNameSuffix++;
        }

        return redirect()->route('admin.player-team.index');
    }

}
