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

        // Obter o número total de jogadores confirmados
        $totalConfirmedPlayers = Player::where('is_presence', true)->count();

        // Obter todos os jogadores confirmados e classificá-los por habilidade
        $confirmedPlayers = Player::where('is_presence', true)->orderBy('skill_level', 'desc')->get();

        // Embaralhar aleatoriamente os jogadores classificados
        $shuffledPlayers = $confirmedPlayers->shuffle();

        // Inicialize um array para rastrear quantos goleiros já foram alocados em cada time
        $goalkeeperAssigned = [];

        // Distribuir os jogadores nos times
        foreach ($teams as $team) {
            $numberOfPlayersPerTeam = $team->max_players;

            // Verificar se há jogadores suficientes para realizar o sorteio em pelo menos dois times
            if ($totalConfirmedPlayers < ($numberOfPlayersPerTeam * 2)) {
                return redirect()->route('admin.player-team.index')
                    ->with('error', 'Não é possível realizar o sorteio. O número de jogadores confirmados é insuficiente.');
            }

            $selectedPlayers = collect([]);

            // Garantir que cada time tenha apenas um goleiro
            if (!in_array($team->id, $goalkeeperAssigned)) {
                $selectedGoleiro = $shuffledPlayers->where('is_goalkeeper', true)->first();
                if ($selectedGoleiro) {
                    $selectedPlayers->push($selectedGoleiro);
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

            // Remover os jogadores selecionados
            $shuffledPlayers = $shuffledPlayers->diff($selectedPlayers);
        }

        // Criar times reservas se ainda houver jogadores não alocados
        $remainingPlayersCount = $shuffledPlayers->count();

        while ($remainingPlayersCount > 0) {
            $playersPerReserveTeam = min($remainingPlayersCount, 6); // Máximo de 6 jogadores por time reserva

            $reserveTeam = Team::create([
                'name' => 'Time Reserva ' . (count($teams) + 1),
                'max_players' => $playersPerReserveTeam,
            ]);

            // Adicionar um goleiro ao time reserva se ainda houver goleiros não alocados
            if ($shuffledPlayers->where('is_goalkeeper', true)->count() > 0) {
                $selectedGoleiro = $shuffledPlayers->where('is_goalkeeper', true)->first();
                PlayerTeam::create([
                    'player_id' => $selectedGoleiro->id,
                    'team_id' => $reserveTeam->id,
                ]);
                $shuffledPlayers = $shuffledPlayers->diff([$selectedGoleiro]);
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
