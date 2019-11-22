<?php

namespace App\Services\Client;

use App\Exceptions\SOAPNotEnabledException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use SoapClient;

abstract class ClientRequest
{
    const MAX_TIME_OUT = 60;
    const SOAP = 'soap';
    const JSON = 'json';

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $requestType = null;

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

    /**
     * @var string
     */
    protected $format = self::JSON;


    public function __construct(
        $requestType,
        $requestUrl,
        $requestHeader,
        $requestBody = [],
        Client $client = null
    ) {
        $this->client = $client;
        $this->requestType = strtoupper($requestType);
        $this->url = $requestUrl;
        $this->headers = $requestHeader;
        $this->body = $requestBody;
    }

    /**
     * @return $this
     * @throws SOAPNotEnabledException
     */
    public function soapContent()
    {
        // Check if SOAP is enabled on the server
        if (! extension_loaded('soap')) {
            throw new SOAPNotEnabledException();
        }

        $this->format = self::SOAP;
    }

    /**
     * @return $this
     */
    public function urlCodedContent()
    {
        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';

        return $this;
    }

    /**
     * @return $this
     */
    public function jsonContent()
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->format = self::JSON;

        return $this;
    }

    /**
     * @param $requestBody
     * @return mixed|string
     */
    public function buildRequestBody($requestBody)
    {
        // We can use interface for this but let's stick with switch case, don't over engineer
        switch ($this->format) {
            case 'json':
                return json_decode($requestBody);
                break;
            case 'url-encoded':
                return http_build_query($requestBody);
                break;
            default:
                return $requestBody;
        }
    }

    public function send()
    {
        if ($this->url === null || $this->requestType === null) {
            throw new InvalidArgumentException;
        }
        try {
            // Don't wanna over engineer this so we just put this here
            if ($this->format === self::SOAP) {
                $soapClient = new SoapClient($this->url);
                $soapClient->__setLocation($this->url);

                $request = $soapClient->__soapCall($this->requestType, $this->body);
                $this->setResponse($request);
            } else {
                $request = new Request($this->requestType, $this->url, $this->headers, $this->body);
                $this->setResponse($this->client->send($request, $this->curlConfig()));
            }
            return $this;
        } catch (ClientException $exception) {
            $this->setResponse($exception->getResponse());
            return $this;
        } catch (ServerException $exception) {
            $this->setResponse($exception->getResponse());
            return $this;
        } catch (\Exception $e) {
            Log::critical($e->getTraceAsString());
            throw $e;
        }
    }

    private function curlConfig()
    {
        return [
            'curl' => [
                CURLOPT_TIMEOUT         =>  self::MAX_TIME_OUT
            ]
        ];
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

}
