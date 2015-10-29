<?php


namespace Craftwb\LastFMApiBundle\Tests\Unit;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GuzzleApiClientTest extends KernelTestCase
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
	public function test_user_getinfo_returns_json()
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
	 */
	public function test_it_throws_a_client_exception()
	{
		$sut = $this->getMockBuilder('GuzzleHttp\Client')
			->disableOriginalConstructor()
			->getMock();

		$sut->expects($this->any())
			->method('get')
			->with('user.getInfo', $this->username);

		$this->setExpectedException('GuzzleHttp\Exception\ClientException');
	}
}
