<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\GameResource;

class GamesServices
{
    public function index($request)
    {
        $search = $request->input('search');

        $games = Game::when($search, function ($q) use ($search) {
                             $q->where('game_at', '=', '%' . $search . '%');
                           })
                         ->paginate(4);

        $games->appends(['search' => $search]);

        $games = GameResource::collection($games);

        return view('web.game.index', compact('games'));
    }

    public function create()
    {
        return view('web.game.create');
    }

    public function store($request)
    {
        try {

            $data = $request->only(
                'name'
            );

            Game::create($data);

            session()->flash('success', 'Partida criado com sucesso');


            return redirect()->route('admin.games.index');
        } catch (\Exception $e) {
            Log::error('Erro ao criar Partida: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao criar Partida: ' . $e->getMessage()], 500);
        }
    }

    public function show($publicId)
    {
        $games = Game::where('public_id', $publicId)
                      ->first();

        $games = GameResource::make($games);

        return view('web.game.show', compact('games'));
    }

    public function edit($publicId)
    {
        $games = Game::where('public_id', $publicId)
                      ->first();

        $games = GameResource::make($games);

        return view('web.game.edit', compact('games'));
    }

    public function update($request, $publicId)
    {
        try {
            $data = $request->all();

            $games = Game::where('public_id', $publicId)
                          ->first();

            $games->update($data);

            session()->flash('success', 'Partida atualizado com sucesso');


            return redirect()->route('admin.game.index');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar Partida: '.$e->getMessage());
            return response()->json(['message' => 'Erro ao atualizar Partida: ' . $e->getMessage()], 500);
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
