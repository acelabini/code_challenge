<?php

namespace App\Http\Resources\Players;

use App\Models\Player;
use Illuminate\Http\Resources\Json\Resource;

class PlayerList extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $itemsTransformed = $this
            ->getCollection()
            ->map(function ($player) {
                return $this->formatPlayer($player);
            })->toArray();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $this->total(),
            $this->perPage(),
            $this->currentPage(),
            [
                'path' => $request->fullUrl(),
                'query' => [
                    'page' => $this->currentPage()
                ]
            ]
        );
    }

    protected function formatPlayer(Player $player)
    {
        return [
            'id'    =>  $player->player_id,
            'full_name' =>  $player->player_information['first_name']." ".$player->player_information['second_name']
        ];
    }
}