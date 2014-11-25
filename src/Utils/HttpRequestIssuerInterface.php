<?php

namespace Logga\Utils;

interface HttpRequestIssuerInterface {
	public function post($url, $payload, $headers);
}