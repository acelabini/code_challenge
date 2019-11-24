<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\PlayersRepository;
use App\Services\Client\PremierLeague\PremierLeagueClientService;

class PlayerService
{
    const PAGINATE_PLAYERS = 20;

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

            // Assign player id as index
            $players = [];
            foreach ($playerList as $player) {
                $players[$player['id']] = $player;
            }

            $playerIds = array_keys($players);
            // Get existing players
            $existingPlayers = $this->playerRepository->getPlayersByIds($playerIds)->toArray();
            // differentiate the existing players to the new fetched players
            $newPlayerIds = array_diff($playerIds, $existingPlayers);
            $this->processCollectedPlayers($players, $newPlayerIds);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Process the new set of fetched players
     *
     * @param array $players
     * @param array $newPlayerIds
     */
    private function processCollectedPlayers(array $players, array $newPlayerIds)
    {
        foreach ($newPlayerIds as $id) {
            if (!isset($players[$id])) continue;
            $playerInfo = $players[$id];

            $this->playerRepository->create([
                'player_id'             =>  $id,
                'player_information'    =>  $playerInfo
            ]);
        }
    }

    public function getPlayers()
    {
        return $this->playerRepository->getPlayers(self::PAGINATE_PLAYERS);
    }

    public function getPlayer(int $playerId) : Player
    {
        return $this->playerRepository->get($playerId);
    }
}