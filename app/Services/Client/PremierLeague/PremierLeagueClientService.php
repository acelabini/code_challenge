<?php

namespace App\Services\Client\PremierLeague;

use App\Services\Client\ClientRegistry;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PremierLeagueClientService
{
    protected $clientRegistry;

    protected $config;

    /**
     * PremierLeagueClientService constructor.
     * @param ClientRegistry $clientRegistry
     * @param array $config
     */
    public function __construct(ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
        $this->config = config('clients.premier_league');
    }

    /**
     * @param $uri
     * @param $method
     * @param array $parameters
     * @return mixed
     */
    private function sendRequest(
        $uri,
        $method,
        array $parameters = []
    ) {
        try {
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
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            throw new \RuntimeException("Something went wrong.");
        }
    }

    /**
     * Set additional configuration
     *
     * @param array $config
     * @return $this
     */
    public function setConfig($config = [])
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }

    /**
     * Fetch players from api
     *
     * @return array|null
     */
    public function fetchPlayers()
    {
        $request = $this->sendRequest(
            "bootstrap-static/",
            "get"
        );

        return $request[array_get($this->config, "player.index")] ?? null;
    }
}
