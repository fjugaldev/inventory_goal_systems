<?php

namespace App\Service;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class HttpService
 * Handles http request vía GuzzleHttp Client.
 */
class HttpService
{
    // CONSTANTS
    // CLIENTS
    const API = 'api';
    const API_DATA = 'api_data';
    // HTTP Methods.
    const METHOD_GET     = 'GET';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    // HTTP STATUS CODE RESPONSES
    const STATUS_200     = 200;
    const STATUS_201     = 201;
    const STATUS_301     = 301;
    const STATUS_401     = 401;
    const STATUS_403     = 403;
    const STATUS_404     = 404;
    const STATUS_500     = 500;
    const STATUS_503     = 503;

    /**
     * @var array
     */
    protected $httpClient;

    /**
     * HttpService constructor.
     * @param Client $httpClient
     * @param Client $httpClientData
     */
    public function __construct(Client $httpClient, Client $httpClientData)
    {
        $this->setClient([
            self::API      => $httpClient,
            self::API_DATA => $httpClientData,
        ]);
    }


    /**
     * Makes the Http request using guzzle.
     * @param string $uri
     * @param string $method
     * @param array  $options
     * @param string $apiClient
     *
     * @return ResponseInterface;
     *
     * @throws \Exception
     */
    public function request(string $uri, string $method = 'GET', array $options = [], string $apiClient = self::API): ResponseInterface
    {
        try {
            // Sends the request via GuzzleHttp.
            return $this->getClient($apiClient)->request($method, $uri, $options);

        } catch (GuzzleException $e) {
            // Throws an Exception.
            throw new \Exception(json_encode(["code" => $e->getCode(), "message" => $e->getMessage()]));
        }
    }

    /**
     * Gets the GuzzleHttp Client
     * @param string $apiClient
     *
     * @return Client
     */
    private function getClient($apiClient): Client
    {
        return $this->httpClient[$apiClient];
    }

    /**
     * Sets de GuzzleHttp Client
     * @param array $httpClient
     *
     * @return HttpService
     */
    private function setClient(array $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }
}