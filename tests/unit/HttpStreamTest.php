<?php

namespace Logga\Tests\Unit;

use Logga\Formatters\EmptyFormatter;
use Logga\LogLevel;
use Logga\Streams\HttpStream;

class HttpStreamTest extends \PHPUnit_Framework_TestCase {
	private $stream;
	private $issuer;

	public function testStreamShouldIssuePostRequestsToTheProvidedUrl() {
		$this->issuer = $this->getMock('Logga\Utils\HttpRequestIssuerInterface');
		$this->issuer->expects($this->once())
			->method('post')
			->with(
				$this->equalTo('example.com'),
				$this->equalTo(json_encode(['msg' => 'Sample log message', 'level' => LogLevel::DEBUG])),
				$this->equalTo(['Content-Type: application/json'])
			);
		$this->stream = new HttpStream(new EmptyFormatter(), 'example.com', $this->issuer);

		$this->stream->open();
		$this->stream->log('Sample log message', LogLevel::DEBUG);
	}
}