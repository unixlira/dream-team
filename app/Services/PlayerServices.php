<?php

namespace App\Services;

use App\Models\Player;
use App\Http\Resources\PlayerResource;
use App\Models\PlayerTeam;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PlayerServices
{
    public function index($request)
    {
        $search = $request->input('search');

        $players = Player::when($search, function ($q) use ($search) {
                             $q->where('name', 'like', '%' . $search . '%');
                           })
                         ->orderByDesc('id')
                         ->paginate(4);

        $players->appends(['search' => $search]);

        $players = PlayerResource::collection($players);

        return view('web.player.index', compact('players'));
    }

    public function create()
    {
        return view('web.player.create');
    }

    public function store($request)
    {
        try {

            $data = $request->only(
                'name',
                'skill_level',
                'is_goalkeeper',
                'is_presence'
            );

            Player::create($data);

            session()->flash('success', 'Jogador criado com sucesso');


            return redirect()->route('admin.player.index');
        } catch (\Exception $e) {
            Log::error('Erro ao criar jogador: '.$e->getMessage());
            session()->flash('error', 'Erro ao criar jogador');
            return redirect()->route('admin.player.index');
        }
    }

    public function show($publicId)
    {
        $player = Player::where('public_id', $publicId)
                        ->first();

        $player = PlayerResource::make($player);

        return view('web.player.show', compact('player'));
    }

    public function edit($publicId)
    {
        $player = Player::where('public_id', $publicId)
                        ->first();

        $player = PlayerResource::make($player);

        return view('web.player.edit', compact('player'));
    }

    public function update($request, $publicId)
    {
        try {
            $data = $request->all();

            $player = Player::where('public_id', $publicId)
                            ->first();

            $player->update($data);

            session()->flash('success', 'Jogador atualizado com sucesso');


            return redirect()->route('admin.player.index');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar jogador: '.$e->getMessage());
            session()->flash('error', 'Erro ao atualizar jogador');
            return redirect()->route('admin.player.index');
        }
    }

    public function destroy($publicId)
    {
        try {

            $player = Player::where('public_id', $publicId)
                            ->first();

            PlayerTeam::where('player_id', $player->id)
                      ->delete();

            $player->delete();

            session()->flash('error', 'Jogador excluido com sucesso');

            return redirect()->route('admin.player.index', [], Response::HTTP_FOUND);
        } catch (\Exception $e) {
            Log::error('Erro ao excluir jogador: '.$e->getMessage());
            session()->flash('error', 'Erro ao excluir jogador');
            return redirect()->route('admin.player.index');
        }
    }
}
