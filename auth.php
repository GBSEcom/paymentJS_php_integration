<?php
/**
 * authorizeSession()
 *
 * This function will authorize the merchant using
 * their credentials.
 */
function authorizeSession() {
	require_once "./config.php";
	$nonce = time() * 1000 + rand();
	$timestamp = time() * 1000;
	$apiKey = $post['credentials']['apiKey'];
	$secretKey = $post['credentials']['apiSecret'];
	$contentType = 'application/json';
	$data = $post['gatewayConfig']; //merchant's gateway credentials

	//API service URLs
	$url = 'https://cert.api.firstdata.com/paymentjs/v2/merchant/authorize-session'; //uat: Customer sandbox

	//$url = 'https://prod.api.firstdata.com/paymentjs/v2/merchant/authorize-session'; //prod: Production aka live

	$jsonPayload = json_encode($data);
	//message components
	$msg = $apiKey . $nonce . $timestamp . $jsonPayload;
	//message signature signed with ApiSecret and message
	$messageSignature = base64_encode(hash_hmac('sha256', $msg, $secretKey));
	
	//header array for auth request
	$headers = array(
		'Api-Key: ' . $apiKey,
		'Content-Type: ' . $contentType,
		'Content-Length: ' . strlen($jsonPayload),
		'Message-Signature: ' . $messageSignature,
		'Nonce: ' . $nonce,
		'Timestamp: ' . $timestamp
	);

	//cURL function to get the response 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$response = curl_exec($ch);
	$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	$header = [];
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	foreach(explode("\r\n", trim(substr($response, 0, $header_size))) as $row) {
	    if(preg_match('/(.*?): (.*)/', $row, $matches)) {
	        $header[$matches[1]] = $matches[2];
	    }
	}
	//response headers
	$client_token = $header['Client-Token'];
	$responseNonce =  $header['Nonce'];
	//response body
	$body = substr($response, $header_size);
	$publicKeyBase64 = substr($body, 20, -2); //extract publicKeyBase64 from the response body
	
    $data = [];
	if ($http_status === 200) {
		if ($responseNonce == $nonce) {
			$data = ['clientToken'=> $client_token, 'publicKeyBase64' => $publicKeyBase64];
			myCallback($data);
			
		} else {
	      	throw new Exception('nonce validation failed for nonce "' + $nonce + '"', 1);
	     }	
	} else {
      	throw new Exception('received HTTP ' + $http_status, 1);
    };
}

/**
 * callback function to send clientToken 
 * for tokenization
 */
function myCallback($data){
	if($data){
		header('Content-Type: application/json');
		$resp =  json_encode($data);
		echo $resp;
	}
}

authorizeSession();
	
?>