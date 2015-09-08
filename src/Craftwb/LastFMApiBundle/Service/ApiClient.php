<?php

namespace Craftwb\LastFMApiBundle\Service;

interface ApiClient
{
	/**
	 * @var $method | Api method
	 * @var $user | The user
	 */
	public function callApi($method, $user);
}