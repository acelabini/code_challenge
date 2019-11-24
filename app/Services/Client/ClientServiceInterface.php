<?php

namespace App\Services\Client;

interface ClientServiceInterface {
    /**
     * Send request
     *
     * @param $uri
     * @param $method
     * @param array $parameters
     * @return mixed
     */
    public function sendRequest($uri, $method, array $parameters = []);
}