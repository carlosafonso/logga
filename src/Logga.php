<?php
	/**
	 * logga.php
	 *
	 * A convenient, lightweight logging library for PHP.
	 *
	 * @author	Carlos Afonso
	 *
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

		private $_streams;

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
			$stream->open();
		}

		public function removeStream($idx) {
			array_splice($this->_streams, $idx, 1);
		}

		public function clearStreams() {
			$this->_streams = array();
		}

		public function debug($msg) {
			$this->_log($msg, LogLevel::DEBUG);
		}

		public function info($msg) {
			$this->_log($msg, LogLevel::INFO);
		}

		public function notice($msg) {
			$this->_log($msg, LogLevel::NOTICE);
		}

		public function warning($msg) {
			$this->_log($msg, LogLevel::WARNING);
		}

		public function error($msg) {
			$this->_log($msg, LogLevel::ERROR);
		}

		public function critical($msg) {
			$this->_log($msg, LogLevel::CRITICAL);
		}

		public function alert($msg) {
			$this->_log($msg, LogLevel::ALERT);
		}

		public function emergency($msg) {
			$this->_log($msg, LogLevel::EMERGENCY);
		}

		/**
		 * @deprecated	2.1.0	The FATAL log level does not adhere
		 *	to the PSR-3 standard and is no longer used by Logga. Calls
		 *	to this function will log an EMERGENCY level message instead.
		 *
		 */
		public function fatal($msg) {
			trigger_error("The FATAL log level is no longer supported and will be removed in future versions", E_USER_DEPRECATED);
			$this->emergency($msg);
		}

		private function _log($msg, $level) {
			foreach ($this->_streams as $stream)
				if ($stream->isEnabled() && $stream->getMinLevel() <= $level)
					$stream->log($msg, $level);
		}
	}