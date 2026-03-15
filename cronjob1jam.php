<?php
//header('refresh:3600; url=cronjob5mnt.php');
include 'page/config/db.php';
mysqli_query($con, "SET sql_mode = ''");
$from = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:00:00').' -1 hour'));
$to = date('Y-m-d H:00:00');
$checkQuery = mysqli_query($con, "SELECT * FROM data WHERE status_sispek = '' and date(waktu) = CURDATE()");
$alldata = array();
if (mysqli_num_rows($checkQuery) <> 0) {
	$sandbox_url = 'http://mwsolusi.co.id/sispek/sandbox/index2.php';
	$client_id = client_id();
	$secret_id = secret_id();
	$key = md5($client_id.$secret_id);
	$curl_header = array(
		"key:$key"
	);
	while ($checkData = mysqli_fetch_array($checkQuery, MYSQLI_ASSOC)) {
		$curl_data = array();
		$curl_data['parameter'] = $checkData['parameter'];
		$curl_data['value'] = $checkData['value'];
		$curl_data['waktu'] = $checkData['waktu'];
		$curl_data['laju_alir'] = $checkData['laju_alir'];
		$curl_data['status_gas'] = $checkData['status_gas'];
		$curl_data['status_partikulat'] = $checkData['status_partikulat'];
		$curl_data['status'] = $checkData['status'];
		$curl_data['fuel'] = $checkData['fuel'];
		$curl_data['load'] = $checkData['load'];
		$curl_data['cerobong_id'] = $checkData['cerobong_id'];
		$alldata[] = $curl_data;
	}
	//echo json_encode($alldata);
	
	$send = curl($sandbox_url, $curl_header, json_encode($alldata));
	$response = json_decode($send, true);
	echo $send;
	if ($response['code'] == 200) {
		mysqli_query($con, "update data set status_sispek = 'Terkirim' where status_sispek = '' and date(waktu) = CURDATE()");
	}
	
}
?>
