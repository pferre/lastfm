<?php


namespace Craftwb\LastFMApiBundle\Service;

use GuzzleHttp\Client;
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
        $client = new Client();

        $this->client = $client;

        $this->container = $container;
    }
    
    /**
     * @param $method
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function callApi($method)
    {
        $request = $this->client->get(
            $this->container->getParameter('lastfm_base_uri'),
            $this->requestParameters($method)
        );

        $response = $request->send();

        return json_decode($response, true);
    }

    /**
     * @param $method
     * @return array
     */
    private function requestParameters($method)
    {
        return [
            'query' => [
                'method' => strtolower($method),
                'apikey' => $this->container->getParameter('lastfm_user_apikey'),
                'user' => $this->container->getParameter('lastfm_user'),
                'format' => $this->response_format,
            ]
        ];
    }

}