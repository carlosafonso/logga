<?php

namespace Logga\Tests\Unit;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;

use Logga\Formatters\EmptyFormatter;
use Logga\LogLevel;
use Logga\Streams\FileStream;

class FileStreamTests extends \PHPUnit_Framework_TestCase {

	/**
	 * @var FileStream
	 */
	private $stream;

	/**
	 * @var vfsStreamDirectory
	 */
	private $root;

	public function setUp() {
		parent::setUp();
		$this->stream = new FileStream();
		$this->root = vfsStream::setup('testdir');
	}

	public function testDefaultFilenameShouldBeDefaultLogLog() {
		$this->assertEquals('default_log', $this->stream->getFileName());
	}

	public function testDefaultPathShouldBeExecutionPath() {
		$this->assertEquals(getcwd(), $this->stream->getFilePath());
	}

	public function testFileShouldNotBeTruncatedByDefault() {
		$this->assertFalse($this->stream->isFileTruncated());
	}

	public function testDatetimeShouldNotBeAppendedToFileNameByDefault() {
		$this->assertFalse($this->stream->isDatetimeAppended());
	}

	public function testStreamShouldAllowSettingACustomFileName() {
		$this->stream->setFileName('custom_filename');

		$this->assertEquals('custom_filename', $this->stream->getFileName());
	}

	public function testStreamShouldAllowSettingACustomPath() {
		$this->stream->setFilePath('my/custom/path');

		$this->assertEquals('my/custom/path', $this->stream->getFilePath());
	}

	public function testStreamShouldAllowEnablingFileTruncating() {
		$this->stream->setTruncateFile(true);

		$this->assertTrue($this->stream->isFileTruncated());
	}

	public function testStreamShouldAllowEnablingAppendingDatetime() {
		$this->stream->setAppendDatetime(true);

		$this->assertTrue($this->stream->isDatetimeAppended());
	}

	public function testStreamShouldCheckIfFileExistsAndCreateItIfItDoesnt() {
		$this->stream->setFilePath(vfsStream::url('testdir'));

		$this->assertFalse($this->root->hasChild('default_log.log'));
		$this->stream->open();
		$this->assertTrue($this->root->hasChild('default_log.log'));
	}

	public function testStreamShouldCheckIfPathExistsAndCreateItIfItDoesnt() {
		$this->stream->setFilePath(vfsStream::url('testdir/nonexisting/folder'));

		$this->assertFalse($this->root->hasChild('nonexisting'));
		$this->stream->open();
		$this->assertTrue($this->root->hasChild('nonexisting/folder/default_log.log'));
		$this->assertEquals(0775, $this->root->getChild('nonexisting/folder')->getPermissions());
	}

	/**
	 * @expectedException			Logga\Exceptions\LoggaException
	 * @expectedExceptionMessage	Unable to create log file
	 */
	public function testStreamShouldThrowAnExceptionIfItFailsToCreateLogFile() {
		$this->stream->setFilePath(vfsStream::url('testdir'));
		$this->root->addChild(vfsStream::newFile('default_log.log', 000));

		$this->stream->open();
	}

	/**
	 * @expectedException			Logga\Exceptions\LoggaException
	 * @expectedExceptionMessage	Unable to create log folder
	 */
	public function testStreamShouldThrowAnExceptionIfItFailsToCreateThePath() {
		$this->stream->setFilePath(vfsStream::url('testdir/nonexisting/folder'));
		$this->root->addChild(vfsStream::newDirectory('nonexisting', 0000));

		$this->stream->open();
	}

	public function testStreamShouldWriteToTheSpecifiedFile() {
		$this->stream->setFilePath(vfsStream::url('testdir'));
		$this->stream->setFileName('custom_filename');

		$this->stream->open();

		$this->assertTrue($this->root->hasChild('custom_filename.log'));
	}

	public function testStreamShouldAddDatetimeToFileNameIfEnabled() {
		$this->stream->setFilePath(vfsStream::url('testdir'));
		$this->stream->setAppendDatetime(true);

		$this->stream->open();

		$this->assertTrue($this->root->hasChild('default_log_' . date('Y-m-d_H-i-s') . '.log'));
	}

	public function testStreamShouldWriteTracesToFile() {
		$this->stream = new FileStream(new EmptyFormatter());
		$this->stream->setFilePath(vfsStream::url('testdir'));

		$this->stream->open();
		$this->stream->log("A debug trace", LogLevel::DEBUG);
		$this->stream->log("An info trace", LogLevel::INFO);
		$this->stream->log("A notice trace", LogLevel::NOTICE);
		$this->stream->log("A warning trace", LogLevel::WARNING);
		$this->stream->log("An error trace", LogLevel::ERROR);
		$this->stream->log("A critical trace", LogLevel::CRITICAL);
		$this->stream->log("An alert trace", LogLevel::ALERT);
		$this->stream->log("An emergency trace", LogLevel::EMERGENCY);
		$this->stream->close();

		$logFile = $this->root->getChild('default_log.log');
		$content = $logFile->getContent();
		$this->assertEquals("A debug trace\nAn info trace\nA notice trace\nA warning trace\nAn error trace\nA critical trace\nAn alert trace\nAn emergency trace\n",
			$content);
	}
}