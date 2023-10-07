<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamServices;
use App\Http\Requests\TeamRequest;

class TeamController extends Controller
{
    public function __construct(
        public TeamServices $teamService
    ){}

    public function index(Request $request)
    {
        return $this->teamService->index($request);
    }

    public function create()
    {
        return $this->teamService->create();
    }

    public function store(TeamRequest $request)
    {
        return $this->teamService->store($request);
    }

    public function show($publicId)
    {
        return $this->teamService->show($publicId);
    }

    public function edit($publicId)
    {
        return $this->teamService->edit($publicId);
    }

    public function update(TeamRequest $request, $publicId)
    {
        return $this->teamService->update($request, $publicId);
    }

    public function destroy($publicId)
    {
        return $this->teamService->destroy($publicId);
    }
}
