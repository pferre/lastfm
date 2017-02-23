<?php


namespace Craftwb\LastFMApiBundle\Tests\Unit;

use Craftwb\LastFMApiBundle\Service\GuzzleApiClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;

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
		$sut = $this->getMockBuilder(GuzzleApiClient::class)
			->disableOriginalConstructor()
			->getMock();

		$sut->expects($this->once())
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
		$request = $this->getMockBuilder(RequestInterface::class)
						->disableOriginalConstructor()
						->getMock();

		$sut = $this->getMockBuilder(GuzzleApiClient::class)
			->disableOriginalConstructor()
			->setMethods(['call'])
			->getMock();
		$sut->expects($this->once())->method('call')->willThrowException(new ClientException('', $request));

		$this->expectException(ClientException::class);

		$sut->call('user.getInfo', $this->username);
	}
}
