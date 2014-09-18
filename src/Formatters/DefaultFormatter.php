<?php

	namespace Logga\Formatters;

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
				\Logga\LogLevel::DEBUG => 'DEBUG    ',
				\Logga\LogLevel::INFO => 'INFO     ',
				\Logga\LogLevel::NOTICE => 'NOTICE   ',
				\Logga\LogLevel::WARNING => 'WARNING  ',
				\Logga\LogLevel::ERROR => 'ERROR    ',
				\Logga\LogLevel::CRITICAL => 'CRITICAL ',
				\Logga\LogLevel::ALERT => 'ALERT    ',
				\Logga\LogLevel::EMERGENCY => 'EMERGENCY'
			);

		public function format($msg, $level) {

			if (is_object($msg) || is_array($msg))
				$msg = json_encode($msg);

			$format = "[%s][%s]: %s";
			return sprintf($format, date('Y-m-d H:i:s'), $this::$_LEVELS[$level], $msg);
		}
	}