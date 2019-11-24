<?php

namespace App\Services\Client\Format;

use App\Services\Client\ClientRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class ClientJSON extends ClientRequest
{
    /**
     * @return $this
     */
    public function urlCodedContent()
    {
        $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        $this->body = http_build_query($this->body);

        return $this;
    }

    /**
     * @return $this
     */
    public function buildClient()
    {
        $this->headers['Content-Type'] = 'application/json';
        $this->body = json_encode($this->body);

        return $this;
    }

    /**
     * @return $this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send()
    {
        if ($this->url === null || $this->method === null) {
            throw new \InvalidArgumentException();
        }
        try {
            $request = new Request($this->method, $this->url, $this->headers, $this->body);
            $response = $this->client->send($request, $this->curlConfig());
            $this->setResponse(json_decode($response->getBody()->getContents(), true));

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

    /**
     * @return array
     */
    private function curlConfig()
    {
        return [
            'curl' => [
                CURLOPT_TIMEOUT         =>  self::MAX_TIME_OUT
            ]
        ];
    }
}