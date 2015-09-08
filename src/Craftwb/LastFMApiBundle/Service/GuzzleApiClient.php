<?php

namespace Craftwb\LastFMApiBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DependencyInjection\Container;

class GuzzleApiClient implements ApiClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $response_format = 'json';

    public function __construct(Container $container)
    {
        $this->container = $container;

        $client = new Client();

        $this->client = $client;
    }
    
    /**
     * @param $method
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function callApi($method)
    {
        $response = null;

        try {
            $response = $this->client->get(
                $this->container->getParameter('lastfm_base_uri'),
                $this->buildRequestParameters($method)
            );
        } catch (ClientException $e) {
            return $e->getResponse();
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param $method
     * @return array
     */
    private function buildRequestParameters($method)
    {
        return [
            'query' => [
                'method' => strtolower($method),
                'user' => $this->container->getParameter('lastfm_user'),
                'api_key' => $this->container->getParameter('lastfm_user_apikey'),
                'format' => $this->response_format,
            ]
        ];
    }
}
