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

	public function __construct( Container $container )
	{
		$this->container = $container;

		$client = new Client();

		$this->client = $client;
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
			return $e->getResponse();
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
