<?php

namespace Logga\Tests\Unit;

use Logga\Formatters\EmptyFormatter;
use Logga\LogLevel;

class EmptyFormatterTest extends  \PHPUnit_Framework_TestCase {
	private $formatter;

	public function setUp() {
		parent::setUp();
		$this->formatter = new EmptyFormatter();
	}

	public function testOutputShouldBeEqualToTheGivenMessage() {
		$output = $this->formatter->format('Just a test message', LogLevel::DEBUG);
		$this->assertEquals($output, 'Just a test message');
	}

	public function testPassingAnArrayAsTheMessageShouldReturnAJsonEncodedRepresentation() {
		$array = ['foo' => 'bar', 'baz' => 3];

		$output = $this->formatter->format($array, LogLevel::DEBUG);

		$this->assertEquals(json_encode($array), $output);
	}

	public function testPassingAnObjectAsTheMessageShouldReturnAJsonEncodedRepresentation() {
		$object = new \stdClass();
		$object->foo = 'bar';
		$object->baz = 3;

		$output = $this->formatter->format($object, LogLevel::DEBUG);

		$this->assertEquals(json_encode($object), $output);
	}
}