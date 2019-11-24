<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Support\Facades\DB;

class PlayersRepository extends Repository
{
    public function setModel()
    {
        $this->model = new Player();
    }

    public function getPlayersByIds(array $playerIds)
    {
        return $this->model
            ->whereIn('player_id', $playerIds)
            ->pluck('player_id')
            ;
    }

    public function getPlayers($limit = 10)
    {
        return $this->model
            ->select(DB::raw("*, JSON_EXTRACT(player_information, '$.total_points') as total_points"))
            ->whereNull('deleted_at')
            ->orderBy('total_points', 'desc')
            ->paginate($limit);
    }
}