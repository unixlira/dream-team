<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlayerServices;
use App\Http\Requests\PlayerRequest;

class PlayerController extends Controller
{
    public function __construct(
        public PlayerServices $playerService
    ){}

    public function index(Request $request)
    {
        return $this->playerService->index($request);
    }

    public function create()
    {
        return $this->playerService->create();
    }

    public function store(PlayerRequest $request)
    {
        return $this->playerService->store($request);
    }

    public function show($publicId)
    {
        return $this->playerService->show($publicId);
    }

    public function edit($publicId)
    {
        return $this->playerService->edit($publicId);
    }

    public function update(PlayerRequest $request, $publicId)
    {
        return $this->playerService->update($request, $publicId);
    }

    public function destroy($publicId)
    {
        return $this->playerService->destroy($publicId);
    }
}
