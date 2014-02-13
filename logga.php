<?php

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

		private $_levels = array(NULL, 'DEBUG  ', 'INFO   ', 'WARNING', 'ERROR  ', 'FATAL  ');

		public function __construct($name, $path = './') {
			if (! file_exists($path))
				if (mkdir($path, 0777, TRUE))
					throw new Exception("Unable to create log folder '{$path}'");

			$this->_f = fopen($path . DIRECTORY_SEPARATOR . $name . '_' . date('Y-m-d-H-i-s') . '.log', 'a');
		}

		public function __destruct() {
			fclose($this->_f);
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
			fwrite($this->_f, $this->_format($msg, $level) . "\n");
		}

		private function _format($msg, $level) {
			$format = "[%s][%s]: %s";
			return sprintf($format, date('Y-m-d H:i:s'), $this->_levels[$level], $msg);
		}
	}