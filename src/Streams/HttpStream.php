<?php
	
	namespace Logga\Streams;

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
		private $_additionalParams;

		public function __construct($params = NULL) {
			parent::__construct($params);

			if (! $params || ! isset($params['url']))
				throw new \Logga\Exceptions\LoggaException("HttpStream needs a valid URL but none has been provided");
			else
				$this->_url = $params['url'];

			if (! $params || ! isset($params['additional_params']) || ! is_array($params['additional_params']))
				$this->_additionalParams = array();
			else
				$this->_additionalParams = $params['additional_params'];
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

			$params = array_merge($params, $this->_additionalParams);
			
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