<?php
	
	namespace CarlosAfonso\Logga\Streams;

	/**
	 * HttpStream represents a log stream which
	 * outputs all traces to an HTTP endpoint.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class HttpStream extends LogStream {

		private $_ch;

		private $_url;

		public function __construct($params = NULL) {
			parent::__construct($params);

			if (! $params || ! isset($params['url']))
				throw new \CarlosAfonso\Logga\Exceptions\LoggaException("HttpStream needs a valid URL but none has been provided");
			else
				$this->_url = $params['url'];
		}

		public function open() {
			$this->_ch = curl_init($this->_url);
			curl_setopt($this->_ch, CURLOPT_POST, TRUE);
		}

		public function log($msg, $level) {
			$params = array(
					'msg'	=> $msg,
					'level'	=> $level,
					'time'	=> time()
				);

			$raw = http_build_query($params);
			curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $raw);

			ob_start();
			curl_exec($this->_ch);
			ob_end_clean();
		}

		public function close() {
			curl_close($this->_ch);
		}
	}