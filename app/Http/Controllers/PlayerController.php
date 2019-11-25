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
     * @OA\Post(
     *     path="/api/players",
     *     summary="Get all players",
     *     description="Get all players available",
     *     tags={"PLAYERS"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="The number of items to return",
     *         schema={
     *            "type"="int",
     *            "example"="10"
     *         }
     *     ),
     * )
     *
     * Get all available players
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function playerLists(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $this->validate($request, [
                'limit' =>  'numeric'
            ]);
            $players = $this->playerService->getPlayers($request->get('limit'));

            $this->response->setData(['data' => new PlayerList($players)]);
        });
    }

    /**
     * @OA\Post(
     *     path="/api/players/{player_id}",
     *     summary="Get player by id",
     *     description="Get player by id",
     *     tags={"PLAYERS"},
     *     @OA\Parameter(
     *         name="Player id",
     *         in="path",
     *         description="Player id",
     *         required=true,
     *         schema={
     *            "type"="int"
     *         }
     *     ),
     * )
     *
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