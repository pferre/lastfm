<?php

namespace Craftwb\LastFMApiBundle\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DependencyInjection\Container;

class GuzzleApiClient implements ApiClient
{
	/**
	 * @var GuzzleClient
	 */
	protected $client;

	/**
	 * @var Container
	 * @var GuzzleClient
	 */
	protected $container;

	public function __construct( Container $container, GuzzleClient $guzzle )
	{
		$this->container = $container;

		$this->client = $guzzle;
	}

	/**
	 * @param        $method
	 * @param        $user
	 * @param string $format
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function call( $method, $user, $format = 'json' )
	{
		$response = null;

		try {
			$response = $this->client->get(
				$this->container->getParameter('lastfm_base_uri'),
				$this->buildRequest($method, $user, $format)
			);
		} catch (ClientException $e) {
			throw $e;
		}

		return json_decode($response->getBody(), true);
	}

	/**
	 * @param $method
	 * @param $user
	 * @param $format
	 *
	 * @return array
	 */
	private function buildRequest( $method, $user, $format )
	{
		return [
			'query' => [
				'method'  => strtolower($method),
				'user'    => $user,
				'api_key' => $this->container->getParameter('lastfm_user_apikey'),
				'format'  => $format
			]
		];
	}
}
