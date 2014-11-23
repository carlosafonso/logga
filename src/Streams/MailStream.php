<?php
	
	namespace Logga\Streams;

	/**
	 * MailStream represents a log stream which
	 * sends traces to at least one email address.
	 *
	 * @author Carlos Afonso
	 *
	 */
	class MailStream extends LogStream {

		private $_mailer;
		private $_from;
		private $_to;
		private $_subject;

		public function __construct($params = NULL) {
			parent::__construct($params);

			$this->_mailer = $params['mailer'];
			$this->_from = $params['from'];
			$this->_to = $params['to'];

			$this->_mailer->From = $this->_from;
			$this->_mailer->FromName = 'Logga Mailer';
			$this->_mailer->addAddress($this->_to);
		}

		public function open() {}

		public function log($msg, $level) {
			$this->_mailer->Subject = '[Logga] Log trace';
			$this->_mailer->Body = $this->_formatter->format($msg, $level);
			if (! $this->_mailer->send())
				throw new \Logga\Exceptions\LoggaException("Failed to send mail from '" . $this->_from . "' to '" . $this->_to . "': " . $this->_mailer->ErrorInfo);
		}

		public function close() {}
	}