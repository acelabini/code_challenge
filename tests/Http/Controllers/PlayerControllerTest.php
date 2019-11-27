<?php

use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Services\PlayerService;
use \App\Models\Player;
use Mockery as m;

class PlayerControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testPlayerLists()
    {
        $this->get('/api/players')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function testGetPlayerNotFound()
    {
        $this->get("/api/player/1000000")
            ->assertStatus(404)
            ->assertJsonStructure(['error']);
    }

    public function testGetPlayer()
    {
        $id = 99999;
        factory(Player::class)->create([
            'id' => $id
        ]);
        M::mock(PlayerService::class);

        $this->get("/api/player/{$id}")
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}