<?php

namespace App\Services\Client\Format;

use App\Exceptions\SOAPNotEnabledException;
use App\Services\Client\ClientRequest;
use Illuminate\Support\Facades\Log;

class ClientSOAP extends ClientRequest
{
    /**
     * @return $this
     * @throws SOAPNotEnabledException
     */
    public function buildClient()
    {
        // Check if SOAP is enabled on the server
        if (! extension_loaded('soap')) {
            throw new SOAPNotEnabledException();
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function send()
    {
        if ($this->url === null || $this->method === null) {
            throw new \InvalidArgumentException();
        }
        try {
            $soapClient = new \SoapClient($this->url."?wsdl");
            $soapClient->__setLocation($this->url);
            $request = $soapClient->__soapCall($this->method, $this->body);
            $this->setResponse($request);

            return $this;
        } catch (\Exception $e) {
            Log::critical($e->getTraceAsString());
            throw $e;
        }
    }
}