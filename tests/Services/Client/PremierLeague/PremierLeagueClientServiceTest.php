<?php

use Tests\TestCase;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Services\PlayerService;
use \App\Models\Player;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Pagination\LengthAwarePaginator;
use \App\Services\Client\Format\ClientJSON;
use \App\Services\Client\PremierLeague\PremierLeagueClientService;
use Mockery as m;

class PremierLeagueClientServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFetchPlayersJson()
    {
        $clientService = app(PremierLeagueClientService::class);
        $players = $clientService->fetchPlayers();

        $this->assertIsArray($players);
    }

    public function testFetchPlayersXMLThrowError()
    {
        $clientService = app(PremierLeagueClientService::class)->setConfig(['format' => 'xml']);
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Something went wrong.");
        $clientService->fetchPlayers();
    }

//    public function testFetchPlayersXMLSuccess()
//    {
//        $clientService = app(PremierLeagueClientService::class)->setConfig([
//            'format' => 'xml',
//            'url'   => env("APP_URL")."api"
//        ]);
//        $players = $clientService->fetchPlayers();
//    }
}