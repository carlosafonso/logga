<?php

	namespace Logga\Streams;

	use Logga\Formatters\DefaultFormatter;
	use Logga\Formatters\Formatter;
	use Logga\LogLevel;

	/**
	 * Represents an abstract log stream. All
	 * stream implementations must extend this class.
	 *
	 * @author Carlos Afonso
	 *
	 */
	abstract class LogStream {

		protected $enabled = true;
		protected $minLevel = LogLevel::DEBUG;
		protected $formatter;

		public function __construct(Formatter $formatter = null) {
			if ($formatter == null)
				$formatter = new DefaultFormatter();
			$this->formatter = $formatter;
		}

		public abstract function open();
		public abstract function log($msg, $level);
		public abstract function close();

		public function isEnabled() {
			return $this->enabled;
		}

		public function enable() {
			$this->enabled = TRUE;
		}

		public function disable() {
			$this->enabled = FALSE;
		}

		public function getMinLevel() {
			return $this->minLevel;
		}

		public function setMinLevel($level) {
			$this->minLevel = $level;
		}

		public function getFormatter() {
			return $this->formatter;
		}
	}