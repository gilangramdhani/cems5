<?php
include 'page/config/db.php';
$client_id = client_id();
$secret_id = secret_id();
$verification_url = verification_url();
$key = md5($client_id.$secret_id);
$curl_header = array(
	"key:$key"
);
$curl_data = array(
	'page' => 'client'
);
$send = curl($verification_url, $curl_header, json_encode($curl_data));
$response = json_decode($send, true);
var_dump($response);
?>
