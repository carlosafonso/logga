<?php

	namespace CarlosAfonso\Logga\Formatters;

	class DefaultFormatter extends Formatter {

		private static $_LEVELS = array(NULL, 'DEBUG  ', 'INFO   ', 'WARNING', 'ERROR  ', 'FATAL  ');

		public function format($msg, $level) {
			$format = "[%s][%s]: %s";
			return sprintf($format, date('Y-m-d H:i:s'), $this::$_LEVELS[$level], $msg);
		}
	}