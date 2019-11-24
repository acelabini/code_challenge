<?php

namespace App\Services\Client\PremierLeague;

use App\Services\Client\ClientRegistry;
use GuzzleHttp\Client;

class PremierLeagueClientService
{
    protected $clientRegistry;

    protected $config;

    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
        $this->config = config('clients.premier_league');
    }

    private function sendRequest(
        $uri,
        $method,
        array $parameters = []
    ) {
        $uri = rtrim($this->config["url"], '/') . "/" . ltrim($uri, '/');

        $request = $this->clientRegistry->get($this->config['format'])
            ->setClient(
                $method,
                $uri,
                $parameters,
                [
                    'User-Agent' => 'FplLib/1.1'
                ],
                new Client()
            )->buildClient()->send();

        return $request->getResponse();
    }

    public function fetchPlayers()
    {
        $request = $this->sendRequest(
            "bootstrap-static/",
            "get"
        );
        return $request[array_get($this->config, "player.index")] ?? null;
    }
}
