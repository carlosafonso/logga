<?php

	namespace CarlosAfonso\Logga\Formatters;

	/**
	 * DefaultFormatter a basic implementation of a
	 * trace formatter. Log traces using this formatter
	 * will have the date and time, the log level and
	 * the logged message.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class DefaultFormatter extends Formatter {

		private static $_LEVELS = array(
				\CarlosAfonso\Logga\LogLevel::DEBUG => 'DEBUG    ',
				\CarlosAfonso\Logga\LogLevel::INFO => 'INFO     ',
				\CarlosAfonso\Logga\LogLevel::NOTICE => 'NOTICE   ',
				\CarlosAfonso\Logga\LogLevel::WARNING => 'WARNING  ',
				\CarlosAfonso\Logga\LogLevel::ERROR => 'ERROR    ',
				\CarlosAfonso\Logga\LogLevel::CRITICAL => 'CRITICAL ',
				\CarlosAfonso\Logga\LogLevel::ALERT => 'ALERT    ',
				\CarlosAfonso\Logga\LogLevel::EMERGENCY => 'EMERGENCY'
			);

		public function format($msg, $level) {

			if (is_object($msg) || is_array($msg))
				$msg = json_encode($msg);

			$format = "[%s][%s]: %s";
			return sprintf($format, date('Y-m-d H:i:s'), $this::$_LEVELS[$level], $msg);
		}
	}