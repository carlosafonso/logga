<?php

	namespace CarlosAfonso\Logga\Streams;

	/**
	 * LogStream represents an abstract log stream. All
	 * stream implementations must extend this class.
	 *
	 * @author Carlos Afonso
	 *
	 */
	abstract class LogStream {

		protected $_enabled = TRUE;
		protected $_minLevel = \CarlosAfonso\Logga\LogLevel::DEBUG;
		protected $_formatter;

		public function __construct($params = NULL) {
			$this->_formatter = new \CarlosAfonso\Logga\Formatters\DefaultFormatter();

			if (isset($params['min_level']))
				$this->_minLevel = $params['min_level'];

			if (isset($params['enabled']))
				$this->_enabled = (bool) $params['enabled'];
		}

		public abstract function open();
		public abstract function log($msg, $level);
		public abstract function close();

		public function isEnabled() {
			return $this->_enabled;
		}

		public function enable() {
			$this->_enabled = TRUE;
		}

		public function disable() {
			$this->_enabled = FALSE;
		}

		public function getMinLevel() {
			return $this->_minLevel;
		}

		public function setMinLevel($level) {
			$this->_minLevel = $level;
		}
	}