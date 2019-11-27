<?php

use Tests\TestCase;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\Services\PlayerService;
use \App\Models\Player;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Pagination\LengthAwarePaginator;
use Mockery as m;

class PlayerServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $playerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->playerService = $service = app(PlayerService::class);
    }

    public function testSyncPlayersEmptyList()
    {
        $playerList = [];
        $syncPlayers = $this->playerService->syncPlayers($playerList);
        $this->assertFalse($syncPlayers);
    }

    public function testSyncPlayersLessThanMinimum()
    {
        $player = factory(Player::class)->create();
        $playerList = [
            $player->id   =>  $player->player_information
        ];
        $syncPlayers = $this->playerService->syncPlayers($playerList);
        $this->assertFalse($syncPlayers);
    }

    public function testSyncPlayersUpdateAndCreate()
    {
        $player = factory(Player::class)->create();
        $newCreatedPlayerId = 999;
        $newPlayerTeam = 2;
        $playerList = [
            $player->player_id   =>  ['team' => $newPlayerTeam] + $player->player_information,
            $newCreatedPlayerId  =>  $this->playerInformation($newCreatedPlayerId)
        ];
        $this->playerService->syncPlayers($playerList, 2);
        $updatedPlayer = $this->playerService->getPlayer($player->player_id);
        $newPlayer = $this->playerService->getPlayer($newCreatedPlayerId);

        $this->assertSame($newPlayerTeam, $updatedPlayer->player_information['team']);
        $this->assertSame($newCreatedPlayerId, $newPlayer->player_id);
    }

    public function testGetPlayers()
    {
        factory(Player::class)->create();

        $this->assertInstanceOf(LengthAwarePaginator::class, $this->playerService->getPlayers());
    }

    public function testGetPlayerThrowsModelNotFoundException()
    {
        $service = app(PlayerService::class);
        $this->expectException(ModelNotFoundException::class);
        $service->getPlayer(0);
    }

    public function testGetPlayerReturnPlayer()
    {
        $id = 99999;
        $player = factory(Player::class)->create();

        $fetchPlayer = $this->playerService->getPlayer($id);
        $this->assertSame($player->player_id, $fetchPlayer->player_id);
    }

    private function playerInformation($playerId)
    {
        return [
            'id' => $playerId,
            'bps' => 133,
            'code' => 111457,
            'form' => '0.8',
            'news' => 'Hamstring injury - 75% chance of playing',
            'team' => 1,
            'bonus' => 1,
            'photo' => '111457.jpg',
            'saves' => 0,
            'status' => 'd',
            'threat' => '45.0',
            'assists' => 1,
            'ep_next' => '1.4',
            'ep_this' => '1.4',
            'minutes' => 667,
            'special' => false,
            'now_cost' => 53,
            'web_name' => 'Kolasinac',
            'ict_index' => '27.8',
            'influence' => '122.8',
            'own_goals' => 0,
            'red_cards' => 0,
            'team_code' => 3,
            'creativity' => '111.5',
            'first_name' => 'Sead',
            'news_added' => '2019-11-21T14:30:19.207005Z',
            'value_form' => '0.2',
            'second_name' => 'Kolasinac',
            'clean_sheets' => 1,
            'element_type' => 2,
            'event_points' => 0,
            'goals_scored' => 0,
            'in_dreamteam' => false,
            'squad_number' => null,
            'total_points' => 19,
            'transfers_in' => 43522,
            'value_season' => '3.6',
            'yellow_cards' => 2,
            'transfers_out' => 99938,
            'goals_conceded' => 10,
            'dreamteam_count' => 0,
            'penalties_saved' => 0,
            'points_per_game' => '1.9',
            'penalties_missed' => 0,
            'cost_change_event' => 0,
            'cost_change_start' => -2,
            'transfers_in_event' => 8,
            'selected_by_percent' => '0.7',
            'transfers_out_event' => 1757,
            'cost_change_event_fall' => 0,
            'cost_change_start_fall' => 2,
            'chance_of_playing_next_round' => 75,
            'chance_of_playing_this_round' => 75,
        ];
    }
}