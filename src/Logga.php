<?php
	/**
	 * logga.php
	 *
	 * A convenient, lightweight logging library for PHP.
	 *
	 * @author	Carlos Afonso
	 * @version	2.0.0
	 */
	
	namespace CarlosAfonso\Logga;

	/**
	 * Logga the library's main class. All logging is carried
	 * out by invoking this class' methods.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class Logga {

		private $_f;
		private $_streams;

		private $_levels = array(NULL, 'DEBUG  ', 'INFO   ', 'WARNING', 'ERROR  ', 'FATAL  ');

		public function __construct($streams = NULL) {

			if ($streams == NULL || (is_array($streams) && empty($streams)))
			{
				// default stream (file, to ./log/log_timestamp.log)
				$streams = array(new Streams\FileStream(), new Streams\StandardOutputStream());
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
	}