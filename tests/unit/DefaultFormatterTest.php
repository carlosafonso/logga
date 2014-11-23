<?php

namespace Logga\Tests\Unit;

use Logga\Formatters\DefaultFormatter;
use Logga\LogLevel;

class DefaultFormatterTest extends  \PHPUnit_Framework_TestCase {
	public function testOutputShouldIncludeLevelTimeAndMessage() {
		$formatter = new DefaultFormatter();
		
		$output = $formatter->format('Just a test message', LogLevel::DEBUG);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[DEBUG\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::INFO);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[INFO\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::NOTICE);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[NOTICE\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::WARNING);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[WARNING\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::ERROR);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[ERROR\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::CRITICAL);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[CRITICAL\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::ALERT);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[ALERT\s*\]: Just a test message/si', $output);

		$output = $formatter->format('Just a test message', LogLevel::EMERGENCY);
		$this->assertRegExp('/^\[\d{4}(-\d{2}){2} \d{2}(:\d{2}){2}\]\[EMERGENCY\s*\]: Just a test message/si', $output);
	}
}