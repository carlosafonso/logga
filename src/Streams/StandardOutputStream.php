<?php

	namespace CarlosAfonso\Logga\Streams;

	/**
	 * StandardOutputStream represents a log stream which
	 * outputs all traces to the standard output.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class StandardOutputStream extends LogStream {

		public function __construct($params = NULL) {
			parent::__construct($params);
		}

		public function open() {
			return;
		}

		public function log($msg, $level) {
			echo $this->_formatter->format($msg, $level) . "\n";
		}

		public function close() {
			return;
		}
	}