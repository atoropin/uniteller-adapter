<?php

namespace Rir\UnitellerAdapter\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CancelRequest
{
    private Client $client;

    protected string $baseUrl;

    protected array $parameters;

    /**
     * @param string $baseUrl
     * @param array $parameters
     */
    public function __construct(
        string $baseUrl,
        array  $parameters
    ) {
        $this->client = new Client();

        $this->baseUrl    = $baseUrl;
        $this->parameters = $parameters;
    }

    public function send()
    {
        try {
            $response = $this->client->post(
                $this->baseUrl . '/unblock', [
                    'headers' => [
                        'Accept' => 'application/xml',
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'form_params' => $this->parameters
                ]
            );

            $responseXml = simplexml_load_string($response->getBody()->getContents());

            if ($responseXml instanceof \SimpleXMLElement) {
                $responseCode = (string)$responseXml->orders->order->response_code;
                if ($responseCode === "AS000") {
                    return true;
                }
            }

            return false;

        } catch (RequestException $e) {
        }
    }
}
