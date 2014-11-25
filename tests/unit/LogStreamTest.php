<?php

namespace Logga\Tests\Unit;

use Logga\Formatters\EmptyFormatter;
use Logga\LogLevel;
use Logga\Streams\LogStream;

class LogStreamTests extends \PHPUnit_Framework_TestCase {
	private $stream;

	public function setUp() {
		parent::setUp();
		$this->stream = $this->getMockForAbstractClass('Logga\Streams\LogStream');
	}

	public function testStreamShouldBeEnabledByDefault() {
		$this->assertTrue($this->stream->isEnabled());
	}

	public function testMinLevelShouldBeDebugByDefault() {
		$this->assertEquals(LogLevel::DEBUG, $this->stream->getMinLevel());
	}

	public function testFormatterShouldBeDefaultFormatterByDefault() {
		$this->assertInstanceOf('Logga\Formatters\DefaultFormatter', $this->stream->getFormatter());
	}

	public function testStreamShouldAllowBeingDisabledAndEnabled() {
		$this->stream->disable();
		$this->assertFalse($this->stream->isEnabled());
		$this->stream->enable();
		$this->assertTrue($this->stream->isEnabled());
	}

	public function testStreamShouldAllowSettingACustomMinLevel() {
		$this->stream->setMinLevel(LogLevel::CRITICAL);

		$this->assertEquals(LogLevel::CRITICAL, $this->stream->getMinLevel());
	}

	public function testStreamShouldAllowSettingACustomFormatter() {
		$this->stream = $this->getMockForAbstractClass('Logga\Streams\LogStream', [new EmptyFormatter()]);

		$this->assertInstanceOf('Logga\Formatters\EmptyFormatter', $this->stream->getFormatter());
	}
}