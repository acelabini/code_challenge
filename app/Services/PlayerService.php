<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\PlayersRepository;

class PlayerService
{
    protected $playerRepository;

    public function __construct(PlayersRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Sync players from api
     *
     * @param array $playerList
     * @param int $minimumList
     * @return array|bool
     * @throws \Exception
     */
    public function syncPlayers(array $playerList, $minimumList = 100)
    {
        try {
            if (empty($playerList)) {
                return false;
            }

            // Instruction says: Fetch and store a minimum of 100 players from this data provider
            if (count($playerList) < $minimumList) {
                return false;
            }

            // Assign player id as index
            $players = [];
            foreach ($playerList as $player) {
                $players[$player['id']] = $player;
            }

            $this->processCollectedPlayers($players);

            return $players;
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

    /**
     * @param int $limit
     * @return mixed
     */
    public function getPlayers($limit = 10)
    {
        return $this->playerRepository->getPlayers($limit);
    }

    /**
     * @param int $playerId
     * @return Player
     */
    public function getPlayer(int $playerId) : Player
    {
        return $this->playerRepository->find([
            ['player_id', $playerId]
        ]);
    }
}