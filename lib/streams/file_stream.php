<?php
	
	namespace CarlosAfonso\Logga\Streams;

	class FileStream extends LogStream {

		private $_f;

		private $_path;
		private $_file;

		// IDEALLY
		/*public function __construct($path, $file = NULL) {
			parent::__construct();
			$this->_path = $path;
			$this->_file = $file;
		}*/

		public function __construct($params = NULL) {
			parent::__construct();

			if ($params)
			{
				$this->_path = $params['path'];
				$this->_file = $params['file'];

				if (@$params['date'])
					$this->_file .= '_' . date('Y-m-d-H-i-s');
			}
			else
			{
				$this->_path = getcwd();
				$this->_file = 'default_log' . '_' . date('Y-m-d-H-i-s');
			}

			$this->_file .= '.log';
		}

		public function open() {
			if (! file_exists($this->_path))
				if (mkdir($this->_path, 0777, TRUE))
					throw new \CarlosAfonso\Logga\Exceptions\LoggaException("Unable to create log folder '{$this->_path}'");

			$this->_f = fopen($this->_path . DIRECTORY_SEPARATOR . $this->_file, 'a');
		}

		public function log($msg, $level) {
			fwrite($this->_f, $this->_formatter->format($msg, $level) . "\n");
		}

		public function close() {
			fclose($this->_f);
		}
	}