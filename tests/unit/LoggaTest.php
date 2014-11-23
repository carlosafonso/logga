<?php

	namespace Logga\Tests\Unit;

	use Logga\Logga;
	use Logga\Streams\FileStream;
	use Logga\Streams\StandardOutputStream;

	class LoggaTest extends \PHPUnit_Framework_TestCase {

		const TESTDIR_PREFIX = 'testdir_';

		public static function setUpBeforeClass() {

		}

		public function setUp() {

		}

		public function tearDown() {
			// remove any .log file produced by tests
			array_map('unlink', glob('*.log'));

			// remove any temporary folders produced by tests
			array_map('unlink',  glob(self::TESTDIR_PREFIX . '*' . DIRECTORY_SEPARATOR . '*'));
			array_map('rmdir', glob(self::TESTDIR_PREFIX . '*'));
		}

		public static function tearDownAfterClass() {

		}

		public function testInstantiationWithoutParamtersShouldUseTwoStreamsByDefault() {
			$l = new Logga();
			$streams = $l->getStreams();
			$this->assertEquals(count($streams), 2);
		}

		public function testInstantiationWithoutParamtersShouldUseStdoutAndFileStreamByDefault() {
			$l = new Logga();
			$streams = $l->getStreams();
			foreach ($streams as $stream)
			{
				// TODO: this should be asserted with assertThat(logicalOr())
				$c = get_class($stream);
				$this->assertContains($c, ['Logga\Streams\FileStream', 'Logga\Streams\StandardOutputStream']);
			}
		}

		public function testInstantiationWithoutParametersShouldProduceDefaultFile() {
			$l = new Logga();
			$this->assertFileExists('default_log.log');
		}

		public function testInstantiationWithSingleStreamShouldUseOnlyOneStream() {
			$s = new FileStream();
			$l = new Logga($s);
			$streams = $l->getStreams();
			$this->assertEquals(count($streams), 1);
		}

		public function testInstantiationWithArrayOfStreamsShouldUseAllStreams() {
			$s1 = new FileStream();
			$s2 = new StandardOutputStream();

			$l = new Logga([$s1, $s2]);
			$streams = $l->getStreams();
			$this->assertEquals(count($streams), 2);
		}

		/*
		 * Logging and log levels
		 */
		public function testLoggerShouldLogDebugTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testDebugTrace');
			$this->assertRegExp(
				'/.*testDebugTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogInfoTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testInfoTrace');
			$this->assertRegExp(
				'/.*testInfoTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogNoticeTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testNoticeTrace');
			$this->assertRegExp(
				'/.*testNoticeTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogWarningTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testWarningTrace');
			$this->assertRegExp(
				'/.*testWarningTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogErrorTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testErrorTrace');
			$this->assertRegExp(
				'/.*testErrorTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogCriticalTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testCriticalTrace');
			$this->assertRegExp(
				'/.*testCriticalTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogAlertTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testAlertTrace');
			$this->assertRegExp(
				'/.*testAlertTrace.*/',
				file_get_contents('default_log.log')
			);
		}

		public function testLoggerShouldLogEmergencyTraces() {
			$l = new Logga(new FileStream());
			$l->debug('testEmergencyTrace');
			$this->assertRegExp(
				'/.*testEmergencyTrace.*/',
				file_get_contents('default_log.log')
			);
		}
		

		/*
		 * Streams
		 */
		public function testFileStreamShouldUseProvidedPath() {
			$folder = self::TESTDIR_PREFIX . '1';
			mkdir($folder);
			$l = new Logga(new FileStream(['path' => $folder]));
			$this->assertFileExists($folder . DIRECTORY_SEPARATOR . 'default_log.log');
		}

		public function testFileStreamShouldUseProvidedNonexistentPath() {
			$folder = self::TESTDIR_PREFIX . '1';
			$l = new Logga(new FileStream(['path' => $folder]));
			$this->assertFileExists($folder . DIRECTORY_SEPARATOR . 'default_log.log');
		}

		public function testFileStreamShouldUseProvidedFilename() {
			$l = new Logga(new FileStream(['file' => 'test']));
			$this->assertFileExists('test.log');
		}

		/*
		 * Formatters
		 */
	}