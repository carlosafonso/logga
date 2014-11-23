<?php

namespace Logga\Formatters;

use Logga\Formatters\Formatter;

class EmptyFormatter extends Formatter {
	public function format($msg, $level) {
		if (is_object($msg) || is_array($msg))
				$msg = json_encode($msg);
		return $msg;
	}
}