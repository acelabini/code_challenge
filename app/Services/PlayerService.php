<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\PlayersRepository;
use App\Services\Client\PremierLeague\PremierLeagueClientService;

class PlayerService
{
    protected $clientService;

    protected $playerRepository;

    public function __construct(PremierLeagueClientService $clientService, PlayersRepository $playerRepository)
    {
        $this->clientService = $clientService;
        $this->playerRepository = $playerRepository;
    }

    /**
     * Sync players from api
     *
     * @return bool
     * @throws \Exception
     */
    public function syncPlayers()
    {
        try {
            // initiate the api call
            $playerList = $this->clientService->fetchPlayers();
            if (empty($playerList)) {
                return false;
            }

            // Instruction says: Fetch and store a minimum of 100 players from this data provider
            if (count($playerList) < 100) {
                return false;
            }

            // Assign player id as index
            $players = [];
            foreach ($playerList as $player) {
                $players[$player['id']] = $player;
            }

            $this->processCollectedPlayers($players);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Process the new set of fetched players
     *
     * @param array $players
     */
    private function processCollectedPlayers(array $players)
    {
        // Get existing players
        $playerIds = array_keys($players);
        $existingPlayers = $this->playerRepository->getPlayersByIds($playerIds);

        // Two for loop is better than 2 queries
        // Update the existing players
        foreach ($existingPlayers as $player) {
            // Don't process unknown player id
            if (!isset($players[$player->player_id])) {
                continue;
            }
            $playerInfo = $players[$player->player_id];
            $this->playerRepository->update(
                $player,
                [
                    'player_information' => $playerInfo
                ]
            );
            unset($players[$player->player_id]);
        }

        // Create new players
        foreach ($players as $id => $player) {
            $this->playerRepository->create([
                'player_id'             =>  $id,
                'player_information'    =>  $player
            ]);
        }
    }

    public function getPlayers($limit = 10)
    {
        return $this->playerRepository->getPlayers($limit);
    }

    public function getPlayer(int $playerId) : Player
    {
        return $this->playerRepository->find([
            ['player_id', $playerId]
        ]);
    }
}