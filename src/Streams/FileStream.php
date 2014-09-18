<?php
	
	namespace Logga\Streams;

	/**
	 * FileStream represents a log stream which
	 * outputs all traces to a plain text file. The
	 * file and its path can be configured as desired.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class FileStream extends LogStream {

		private $_f;

		private $_path;
		private $_file;
		private $_truncate;

		// IDEALLY
		/*public function __construct($path, $file = NULL) {
			parent::__construct();
			$this->_path = $path;
			$this->_file = $file;
		}*/

		public function __construct($params = NULL) {
			parent::__construct($params);

			if (! $params || ! isset($params['path']))
				$this->_path = getcwd();
			else
				$this->_path = $params['path'];

			if (! $params || ! isset($params['file']))
				$this->_file = 'default_log';
			else
				$this->_file = $params['file'];

			if (! $params || ! isset($params['truncate']))
				$this->_truncate = FALSE;
			else
				$this->_truncate = (bool) $params['truncate'];

			if (@$params['date'])
				$this->_file .= '_' . date('Y-m-d_H-i-s');

			$this->_file .= '.log';
		}

		public function open() {
			if (! file_exists($this->_path))
				if (! mkdir($this->_path, 0777, TRUE))
					throw new \Logga\Exceptions\LoggaException("Unable to create log folder '{$this->_path}'");

			if (! is_writable($this->_path))
				throw new \Logga\Exceptions\LoggaException("Cannot create log file into folder '{$this->_path}', folder is not writable (check permissions?)");

			$mode = 'a';
			if ($this->_truncate)
				$mode = 'w';

			$this->_f = @fopen($this->_path . DIRECTORY_SEPARATOR . $this->_file, $mode);

			if ($this->_f === FALSE)
				throw new \Logga\Exceptions\LoggaException("Unable to create log file '{$this->_file}'");
		}

		public function log($msg, $level) {
			fwrite($this->_f, $this->_formatter->format($msg, $level) . "\n");
		}

		public function close() {
			fclose($this->_f);
		}
	}