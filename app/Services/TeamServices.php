<?php

namespace App\Services;

use App\Models\Game;
use App\Models\PlayerTeam;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TeamResource;
use Symfony\Component\HttpFoundation\Response;

class TeamServices
{
    public function index($request)
    {
        $search = $request->input('search');

        $teams = Team::when($search, function ($q) use ($search) {
                             $q->where('name', 'like', '%' . $search . '%');
                           })
                         ->paginate(4);

        $teams->appends(['search' => $search]);

        $teams = TeamResource::collection($teams);

        return view('web.team.index', compact('teams'));
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
            session()->flash('error', 'Erro ao criar Time');
            return redirect()->route('admin.team.index');
        }
    }

    public function show($publicId)
    {
        $team = Team::where('public_id', $publicId)
                    ->first();

        $team = TeamResource::make($team);

        return view('web.team.show', compact('team'));
    }

    public function edit($publicId)
    {
        $team = Team::where('public_id', $publicId)
                    ->first();

        $team = TeamResource::make($team);

        return view('web.team.edit', compact('team'));
    }

    public function update($request, $publicId)
    {
        try {
            $data = $request->all();

            $team = Team::where('public_id', $publicId)
                        ->first();

            $team->update($data);

            session()->flash('success', 'Time atualizado com sucesso');


            return redirect()->route('admin.team.index');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar time: '.$e->getMessage());
            session()->flash('error', 'Erro ao atualizar Time');
            return redirect()->route('admin.team.index');
        }
    }

    public function destroy($publicId)
    {
        try {
            $team = Team::where('public_id', $publicId)
                        ->first();

            if (!$team) {
                return redirect()->route('admin.team.index')
                                 ->with('error', 'Time não encontrado.');
            }

            PlayerTeam::where('team_id', $team->id)
                      ->delete();

            Game::where('team_a_id', $team->id)
                ->orWhere('team_b_id', $team->id)
                ->delete();

            $team->delete();

            session()->flash('success', 'Time excluído com sucesso.');

            return response()->json(
                [
                    'status'  => 'success',
                    'message' => 'Time excluído com sucesso.'
                ],Response::HTTP_NO_CONTENT
            );
        } catch (\Exception $e) {
            Log::error('Erro ao excluir time: ' . $e->getMessage());
            session()->flash('error', 'Erro ao excluir Time');
            return response()->json(
                [
                    'status'  => 'success',
                    'message' => 'Erro ao excluir Time: '.$e->getMessage()
                ],Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}
