<?php

namespace App\Services\Client;

abstract class ClientResponseBody
{
    protected $response;

    protected $responseDescription;

    protected $responseCode;

    protected $method;

    public function setResponse($response) : ClientResponseBody
    {
        $this->response = $response;

        return $this;
    }

    public function setResponseDescription($responseDescription) : ClientResponseBody
    {
        $this->responseDescription = $responseDescription;

        return $this;
    }

    public function setResponseCode($responseCode) : ClientResponseBody
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    public function setMethod($method) : ClientResponseBody
    {
        $this->method = $method;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseDescription()
    {
        return $this->responseDescription;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getMethod()
    {
        return $this->method;
    }
}