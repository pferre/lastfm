<?php


namespace Craftwb\LastFMApiBundle\Tests\Unit;

use Craftwb\LastFMApiBundle\Service\GuzzleApiClient;
use GuzzleHttp\Exception\ClientException;

class GuzzleApiClientTest extends \PHPUnit_Framework_TestCase
{
	protected $file_path = 'src/Craftwb/LastFMApiBundle/Tests/Data/data.json';
	protected $json;
	protected $username;

	protected function setUp()
	{
		$this->username = 'pffred';
		$this->json = file_get_contents(getcwd() . '/' . $this->file_path);
	}

	/**
	 * @test
	 */
	public function test_user_get_info_returns_json()
	{
		$sut = $this->getMockBuilder('Craftwb\LastFMApiBundle\Service\GuzzleApiClient')
			->disableOriginalConstructor()
			->getMock();

		$sut->expects($this->any())
			->method('call')
			->with('user.getInfo', $this->username)
			->willReturn($this->json);

		$this->assertJson($sut->call('user.getInfo', $this->username));
	}

	/*
	 * @test
	 * @expectedException GuzzleHttp\Exception\ClientException
	 */
	public function test_user_get_info_returns_exception()
	{

	}
}
