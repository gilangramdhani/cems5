<?php
header('refresh:10; url=loop.php');
date_default_timezone_set("Asia/Jakarta");
function curl($url, $curl_header, $curl_data) {
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($ch); 
	curl_close($ch);      
	return $output;
}
$minnox = 400;
$maxnox = 1050;
$minso2 = 1000;
$maxso2 = 1550;
$minpm = 20;
$maxpm = 85;
$minco2 = 5;
$maxco2 = 21;
$minhg = 400;
$maxhg = 1300;
$mino2 = 500;
$maxo2 = 1500;
for ($i = 1; $i <= 2; $i++) {
	$sandbox_url = 'http://localhost/sandbox/index.php';
	$client_id = '36a3f70e918248671c438a81d478bf6c';
	$secret_id = 'ed472d1bce3ed19f131f9feb8b9f4a77a3f29923f85648a27e3484c4e103bbc0';
	$key = md5($client_id.$secret_id);
	$curl_header = array(
		"key:$key"
	);
	$curl_data = array();

	$curl_data['NOx'] = rand($minnox, $maxnox);
	$curl_data['SO2'] = rand($minso2, $maxso2);
	$curl_data['PM'] = rand($minpm, $maxpm);
	$curl_data['CO2'] = rand($minco2, $maxco2);
	$curl_data['Hg'] = rand($minhg, $maxhg);
	$curl_data['O2'] = rand($mino2, $maxo2);
	$curl_data['waktu'] = date('Y-m-d H:i:s');
	//$curl_data['waktu'] = date('Y-m-d H:i:s',strtotime('2020-08-10 14:39:01'));
	$curl_data['velocity'] = 10.00;
	//$curl_data['laju_alir'] = 10.00;
	$curl_data['status_gas'] = 'valid';
	$curl_data['status_partikulat'] = 'valid';
	$curl_data['status'] = 'valid';
	$curl_data['fuel'] = 'gas';
	$curl_data['load'] = 5.92;
	$curl_data['cerobong_id'] = $i;

	$send = curl($sandbox_url, $curl_header, json_encode($curl_data));
	$response = json_decode($send, true);
	echo $send;
	//echo json_encode($curl_data);
}
?>
