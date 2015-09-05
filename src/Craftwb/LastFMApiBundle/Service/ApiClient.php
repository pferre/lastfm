<?php

namespace Craftwb\LastFMApiBundle\Service;


interface ApiClient
{
	public function callApi($method);
}