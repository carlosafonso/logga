<?php

	use Logga\Logga;

	class LoggaTest extends PHPUnit_Framework_TestCase {

		public static function setUpBeforeClass() {

		}

		public function setUp() {

		}

		public function tearDown() {
			// remove any .log file produced by tests
			array_map('unlink', glob('*.log'));
		}

		public static function tearDownAfterClass() {

		}

		public function testInstantiationWithoutParamtersUsesTwoStreamsByDefault() {
			$l = new Logga();
			$streams = $l->getStreams();
			$this->assertEquals(count($streams), 2);
		}

		public function testInstantiationWithoutParamtersUsesStdoutAndFileStreamByDefault() {
			$l = new Logga();
			$streams = $l->getStreams();
			foreach ($streams as $stream)
			{
				// TODO: this should be asserted with assertThat(logicalOr())
				$c = get_class($stream);
				$this->assertContains($c, ['Logga\Streams\FileStream', 'Logga\Streams\StandardOutputStream']);
			}
		}

		public function testInstantiationWithoutParametersProducesDefaultFile() {
			$l = new Logga();
			$this->assertFileExists('default_log.log');
		}
	}