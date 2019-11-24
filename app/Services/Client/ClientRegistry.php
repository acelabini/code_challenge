<?php

namespace App\Services\Client;

use InvalidArgumentException;

class ClientRegistry
{
    protected $formats = [];

    public function register($clientFormat, ClientRequest $clientRequest)
    {
        $this->formats[$clientFormat] = $clientRequest;

        return $this;
    }

    function get($clientFormat)
    {
        if (!array_key_exists($clientFormat, $this->formats)) {
            throw new InvalidArgumentException("Invalid client format");
        }

        return $this->formats[$clientFormat];
    }
}
