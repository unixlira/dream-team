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

    public function index()
    {
        return $this->gameServices->index();
    }

    public function create()
    {
        return $this->gameServices->create();
    }
}
