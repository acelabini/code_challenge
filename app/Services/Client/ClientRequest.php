<?php

namespace App\Services\Client;

use GuzzleHttp\Client;

abstract class ClientRequest extends ClientResponseBody
{
    const MAX_TIME_OUT = 60;

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $method = null;

    /**
     * @var string
     */
    protected $url = null;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $body = [];

    public function setClient(
        $requestType,
        $requestUrl,
        $requestBody = [],
        $requestHeader = [],
        Client $client = null
    ) {
        $this->client = $client;
        $this->method = $requestType;
        $this->url = $requestUrl;
        $this->headers = $requestHeader;
        $this->body = $requestBody;

        return $this;
    }

    abstract public function buildClient();

    abstract public function send();
}
