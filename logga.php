<?php
	
	namespace CarlosAfonso\Logga;

	/**
	 * logga.php
	 *
	 * A convenient, lightweight logging library for PHP.
	 *
	 * @author	Carlos Afonso
	 * @version	0.1.0
	 */

	define('LOGGA_LVL_DEBUG',	1);
	define('LOGGA_LVL_INFO',	2);
	define('LOGGA_LVL_WARNING',	3);
	define('LOGGA_LVL_ERROR',	4);
	define('LOGGA_LVL_FATAL',	5);

	class Logga {

		private $_f;
		private $_streams;

		private $_levels = array(NULL, 'DEBUG  ', 'INFO   ', 'WARNING', 'ERROR  ', 'FATAL  ');

		public function __construct($streams = NULL) {

			if ($streams == NULL || (is_array($streams) && ! empty($streams) > 0))
			{
				// default stream (file, to ./log/log_timestamp.log)
				$streams = array(new Streams\FileStream());
			}

			// $streams could be a stream or an array of streams
			if (! is_array($streams))
				$streams = array($streams);
			
			foreach ($streams as $stream)
			{
				if (! $stream instanceof Streams\LogStream)
				{
					if (is_array($stream) && (isset($stream['class']) && isset($stream['params'])))
					{
						// build a stream
						$class = __NAMESPACE__ . '\\Streams\\' . $stream['class'];
						$stream = new $class($stream['params']);
					}
					else
					{
						trigger_error('Provided element is not a valid stream or stream configuration array', E_USER_WARNING);
						continue;
					}
				}

				$this->addStream($stream);
				$stream->open();
			}
		}

		public function __destruct() {
			foreach ($this->_streams as $stream)
				$stream->close();
		}

		public function getStreams() {
			return $this->_streams;
		}

		public function addStream(Streams\LogStream $stream) {
			$this->_streams[] = $stream;
		}

		public function removeStream($idx) {
			array_splice($this->_streams, $idx, 1);
			/*unset($this->_streams[$idx]);
			$this->_streams = array_values($this->_streams);	// normalize indices, could also use array_splice()
			*/
		}

		public function clearStreams() {
			$this->_streams = array();
		}

		public function debug($msg) {
			$this->_log($msg, LOGGA_LVL_DEBUG);
		}

		public function info($msg) {
			$this->_log($msg, LOGGA_LVL_INFO);
		}

		public function warning($msg) {
			$this->_log($msg, LOGGA_LVL_WARNING);
		}

		public function error($msg) {
			$this->_log($msg, LOGGA_LVL_ERROR);
		}

		public function fatal($msg) {
			$this->_log($msg, LOGGA_LVL_FATAL);
		}

		private function _log($msg, $level) {
			foreach ($this->_streams as $stream)
				if ($stream->isEnabled() && $stream->getMinLevel() <= $level)
					$stream->log($msg, $level);
		}

		private function _format($msg, $level) {
			$format = "[%s][%s]: %s";
			return sprintf($format, date('Y-m-d H:i:s'), $this->_levels[$level], $msg);
		}
	}
	
	spl_autoload_register(function($class) {

		echo "AUTOLOAD $class\n";
		$els = array_values(array_diff(explode('\\', $class), explode('\\', __NAMESPACE__)));
		$path = __DIR__ . DIRECTORY_SEPARATOR . 'lib';
		
		for ($i = 0; $i < count($els); $i++)
		{
			// '/' + (PathElement -> Path_Element -> path_element)
			// [if last element] + '.php'
			$path .= DIRECTORY_SEPARATOR . strtolower(preg_replace('/([a-z])([A-Z])/', '\1_\2', $els[$i]));
			if ($i == count($els) - 1)
				$path .= '.php';
		}

		require $path;
	});