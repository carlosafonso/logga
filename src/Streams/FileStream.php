<?php
	
	namespace Logga\Streams;

	use Logga\Formatters\Formatter;

	/**
	 * Represents a log stream which
	 * outputs all traces to a plain text file. The
	 * file and its path can be configured as desired.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class FileStream extends LogStream {

		private $file;

		private $fileName;
		private $filePath;
		private $truncateFile;
		private $appendDatetime;

		public function __construct(Formatter $formatter = NULL) {
			parent::__construct($formatter);
			$this->fileName = 'default_log';
			$this->filePath = getcwd();
			$this->truncateFile = false;
			$this->appendDatetime = false;
		}

		public function open() {
			if (! file_exists($this->filePath))
				if (! mkdir($this->filePath, 0775, TRUE))
					throw new \Logga\Exceptions\LoggaException("Unable to create log folder '{$this->filePath}'");

			$mode = 'a';
			if ($this->truncateFile)
				$mode = 'w';

			$datetimeSuffix = '';
			if ($this->appendDatetime)
				$datetimeSuffix = '_' . date('Y-m-d_H-i-s');

			$this->file = @fopen($this->filePath . DIRECTORY_SEPARATOR . $this->fileName . $datetimeSuffix . '.log', $mode);

			if ($this->file === FALSE)
				throw new \Logga\Exceptions\LoggaException("Unable to create log file '{$this->fileName}'");
		}

		public function log($msg, $level) {
			fwrite($this->file, $this->formatter->format($msg, $level) . "\n");
		}

		public function close() {
			fclose($this->file);
		}

		public function getFileName() {
			return $this->fileName;
		}

		public function setFileName($name) {
			$this->fileName = $name;
		}

		public function getFilePath() {
			return $this->filePath;
		}

		public function setFilePath($path) {
			$this->filePath = $path;
		}

		public function isFileTruncated() {
			return $this->truncateFile;
		}

		public function setTruncateFile($truncate) {
			$this->truncateFile = $truncate;
		}

		public function isDatetimeAppended() {
			return $this->appendDatetime;
		}

		public function setAppendDatetime($appendDatetime) {
			$this->appendDatetime = $appendDatetime;
		}
	}