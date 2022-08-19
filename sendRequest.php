<?php 

// sendRequest Method
$ch = curl_init();
function sendRequest($url = false, $args = false, $response = 'def', $metodo = 'def') {
	global $api;
	global $f;
	global $ch;
	
	if (!$url) {
		return false;
	}
	if ($response === 'def') {
		$response = 1;
	}
	if ($metodo === 'def') {
		$post = true;
	} elseif (strtolower($metodo) == 'post') {
		$post = true;
	} else {
		$post = false;
	}
	if (!defined('json_payload') and !$response) {
		define('json_payload', false);
		ignore_user_abort(true);
		$method = explode('/', $url);
		$method = $method[count($method)-1];
		$args['method'] = $method;
		$json = json_encode($args);
		header('Content-Type: application/json');
		$error = error_get_last();
		if (strpos($error['message'], "Cannot modify header information") !== false) {
			unset($args['method']);
			sendRequest($url, $args, 0);
			return json_encode(['result' => "Json Payload failed", 'error' => $error, "contents" => $ob_contents]);
		} else {
			echo $json;
			if (function_exists("fastcgi_finish_request")) {
				fastcgi_finish_request();
			} else {
				ob_end_flush();
				ob_flush();
				flush();
			}
			if (json_decode($obcontents, true)) {
				ob_end_clean();
				ob_start();
				return $obcontents;
			}
		}
		ob_end_clean();
		ob_start();
		return json_encode(['result' => "Json Payload"]);
	} else {
		define('json_payload', false);
		if (!isset($ch)) $ch = curl_init();
		if (!$post) {
			if ($args) { $url .= "?" . http_build_query($args); }
			curl_setopt_array($ch, [
				CURLOPT_URL				=> $url,
				CURLOPT_POST			=> 0,
				CURLOPT_TIMEOUT			=> 5,
				CURLOPT_RETURNTRANSFER	=> $response
			]);
		} else {
			curl_setopt_array($ch, [
				CURLOPT_URL				=> $url,
				CURLOPT_POST			=> 1,
				CURLOPT_POSTFIELDS		=> $args,
				CURLOPT_TIMEOUT			=> 5,
				CURLOPT_RETURNTRANSFER	=> $response
			]);
		}
		ob_end_clean();
		ob_start();
		$output = curl_exec($ch);
		if (!$response) {
			$obcontents = ob_get_contents();
			ob_end_clean();
			ob_start();
			if (json_decode($obcontents, true)) {
				return $obcontents;
			}
		}
		return $output;
	}
}