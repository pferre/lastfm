<?php


namespace Craftwb\LastFMApiBundle\Service;

use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\Container;

class LastFmApi
{
    /**
     * @var Client
     */
    protected $client;

    protected $container;

    public function __construct(Container $container)
    {
        $client = new Client();

        $this->client = $client;

        $this->container = $container;
    }

    /**
     * @param string $format
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUserInfo($format = 'json')
    {
        $this->client->get($this->container->getParameter('lastfm_base_uri'), [
            'query' => [
                'method' => 'user.getinfo',
                'apikey' => $this->container->getParameter('lastfm_user_apikey'),
                'user' => $this->container->getParameter('lastfm_user'),
                'format' => $format,
            ]
        ]);
    }

}