<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GamesServices;
use App\Http\Requests\GameRequest;

class GameController extends Controller
{
    public function __construct(
        public GamesServices $gameServices
    ){}

    public function index(Request $request)
    {
        return $this->gameServices->index($request);
    }

    public function create()
    {
        return $this->gameServices->create();
    }

    public function store(GameRequest $request)
    {
        return $this->gameServices->store($request);
    }

    public function show($publicId)
    {
        return $this->gameServices->show($publicId);
    }

    public function edit($publicId)
    {
        return $this->gameServices->edit($publicId);
    }

    public function update(GameRequest $request, $publicId)
    {
        return $this->gameServices->update($request, $publicId);
    }

    public function destroy($publicId)
    {
        return $this->gameServices->destroy($publicId);
    }
}
