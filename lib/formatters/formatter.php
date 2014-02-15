<?php

	namespace CarlosAfonso\Logga\Formatters;

	abstract class Formatter {
		public abstract function format($msg, $level);
	}