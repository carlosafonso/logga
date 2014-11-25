<?php

namespace Logga\Utils;

use Logga\Utils\HttpRequestIssuerInterface;

class CurlHttpRequestIssuer implements HttpRequestIssuerInterface {
	public function post($url, $payload, $headers) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$res = curl_exec($ch);
		$info = curl_getinfo($ch);
		return ['http_code' => $info['http_code'], 'body' => $res];
	}
}