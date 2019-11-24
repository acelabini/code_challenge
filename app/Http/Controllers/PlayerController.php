<?php

namespace App\Http\Controllers;

use App\Http\Resources\Players\PlayerList;
use App\Services\PlayerService;
use Illuminate\Http\Request;

class PlayerController extends ApiController
{
    protected $playerService;

    public function __construct(PlayerService $playerService)
    {
        parent::__construct();
        $this->playerService = $playerService;
    }

    /**
     * Get all available players
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function playerLists(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $players = $this->playerService->getPlayers();

            $this->response->setData(['data' => new PlayerList($players)]);
        });
    }

    /**
     * Get player by id
     *
     * @param Request $request
     * @param $playerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlayer(Request $request, $playerId)
    {
        return $this->runWithExceptionHandling(function () use ($request, $playerId) {
            $player = $this->playerService->getPlayer($playerId);

            $this->response->setData(['data' => $player->player_information]);
        });
    }
}