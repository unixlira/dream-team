<?php

namespace Tests\Feature;

use App\Models\Team;
use Tests\TestCase;
use App\Models\Game;
use App\Services\GamesServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GamesServicesTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Game::factory(5)
            ->create();

        $service = new GamesServices();
        $view    = $service->index();

        $this->assertEquals('web.game.index', $view->getName());

        $this->assertArrayHasKey('gamesResource', $view->getData());

        $this->assertInstanceOf(AnonymousResourceCollection::class, $view->getData()['gamesResource']);
    }

    public function testCreate()
    {
        Team::factory( 2)
            ->create();

        $service = new GamesServices();

        $response = $service->create();

        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseCount('games', 1);
    }
}

