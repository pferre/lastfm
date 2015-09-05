<?php

namespace Craftwb\LastFMApiBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class CurlApiClient implements ApiClient
{
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function callApi($method)
	{
		$this->init();
	}

	private function init()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->container->getParameter('lastfm_base_uri'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);

		return $response;
	}
}