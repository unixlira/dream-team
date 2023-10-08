<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlayerTeamServices;
use App\Http\Requests\PlayerTeamRequest;

class PlayerTeamController extends Controller
{
    public function __construct(
        public PlayerTeamServices $playerTeamService
    ){}

    public function index()
    {
        return $this->playerTeamService->index();
    }

    public function create()
    {
        return $this->playerTeamService->create();
    }

    public function store(PlayerTeamRequest $request)
    {
        return $this->playerTeamService->store($request);
    }

    public function show($publicId)
    {
        return $this->playerTeamService->show($publicId);
    }

    public function edit($publicId)
    {
        return $this->playerTeamService->edit($publicId);
    }

    public function update(PlayerTeamRequest $request, $publicId)
    {
        return $this->playerTeamService->update($request, $publicId);
    }

    public function destroy($publicId)
    {
        return $this->playerTeamService->destroy($publicId);
    }

    public function shuffle()
    {
        return $this->playerTeamService->shuffle();
    }

    public function reset()
    {
        return $this->playerTeamService->reset();
    }

}
