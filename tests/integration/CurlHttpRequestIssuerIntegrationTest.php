<?php

namespace Logga\Tests\Integration;

use Logga\Utils\CurlHttpRequestIssuer;

class CurlHttpRequestIssuerIntegrationTest extends \PHPUnit_Framework_TestCase {
	private $issuer;

	public function testIssuerShouldIssuePostRequests() {
		$this->issuer = new CurlHttpRequestIssuer();

		$response = $this->issuer->post('http://httpbin.org/post', ['foo' => 'bar', 'baz' => 'qux'], ['X-Sample-Header-1: Sample']);
		$body = json_decode($response['body']);

		$this->assertEquals(200, $response['http_code']);
		$this->assertEquals('bar', $body->form->foo);
		$this->assertEquals('qux', $body->form->baz);
		$this->assertEquals('Sample', $body->headers->{'X-Sample-Header-1'});
	}
}