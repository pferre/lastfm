<?php


namespace Craftwb\LastFMApiBundle\Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GuzzleApiClientTest extends KernelTestCase
{
	/**
	 * @test
	 */
	public function test_user_getinfo_returns_json()
	{
		$response = '';

		$sut = $this->getMockBuilder('Craftwb\LastFMApiBundle\Service\GuzzleApiClient')
			->disableOriginalConstructor()
			->getMock();

		$sut->expects($this->any())
			->method('call')
			->with('user.getInfo', 'pffred')
			->willReturn($response);
	}
}
