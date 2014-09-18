<?php

	namespace Logga\Formatters;

	/**
	 * Formatter an abstract representation of a log trace
	 * formatter. All formatter implementations must extend
	 * this class.
	 *
	 * @author Carlos Afonso
	 *
	 */
	abstract class Formatter {
		public abstract function format($msg, $level);
	}