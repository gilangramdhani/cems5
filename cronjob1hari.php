<?php
include 'page/config/db.php';
mysqli_query($con, "SET sql_mode = ''");
$q = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' -1 day'));
$tempQuery = mysqli_query($con, "select * from temp_table where date(temp_waktu) = date('$q')");
if (mysqli_num_rows($tempQuery) <> 0) {
	while ($tempData = mysqli_fetch_array($tempQuery, MYSQLI_ASSOC)) {
		$temp_parameter = $tempData['temp_parameter'];
		$temp_waktu = $tempData['temp_waktu'];
		$temp_cerobong = $tempData['temp_cerobong'];
		$checkQuery = mysqli_query($con, "select * from data where parameter = '$temp_parameter' and cerobong_id = '$temp_cerobong' and DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') = '$temp_waktu'");
		if (mysqli_num_rows($checkQuery) == 0) {
			$value = 0;
			$velocity = 0;
			$laju_alir = 0;
			$status_gas = 'invalid';
			$status_partikulat = 'invalid';
			$status = 'invalid';
			$fuel = '';
			$load = 0;
			mysqli_query($con, "insert ignore into data (parameter, value, waktu, velocity, laju_alir, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at) values ('$temp_parameter', '$value', '$temp_waktu', '$velocity', '$laju_alir', '$status_gas', '$status_partikulat', '$status', '$fuel', '$load', '$temp_cerobong', NOW())");
			
			$notif_data = mysqli_insert_id($con);
			$notif_status = 'unread';
			mysqli_query($con, "insert ignore into notif (notif_data, notif_status) values ('$notif_data', '$notif_status')");
		}
	}
}
// kirim ke sispek
$check2Query = mysqli_query($con, "SELECT * FROM data WHERE status_sispek = '' and date(waktu) = date('$q')");
if (mysqli_num_rows($check2Query) <> 0) {
	while ($check2Data = mysqli_fetch_array($check2Query, MYSQLI_ASSOC)) {
		$sandbox_url = 'http://mwsolusi.co.id/sispek/sandbox/index.php';
		$client_id = client_id();
		$secret_id = secret_id();
		$key = md5($client_id.$secret_id);
		$curl_header = array(
			"key:$key"
		);
		$curl_data = array();
		$curl_data['parameter'] = $check2Data['parameter'];
		$curl_data['value'] = $check2Data['value'];
		$curl_data['waktu'] = $check2Data['waktu'];
		$curl_data['laju_alir'] = $check2Data['laju_alir'];
		$curl_data['status_gas'] = $check2Data['status_gas'];
		$curl_data['status_partikulat'] = $check2Data['status_partikulat'];
		$curl_data['status'] = $check2Data['status'];
		$curl_data['fuel'] = $check2Data['fuel'];
		$curl_data['load'] = $check2Data['load'];
		$curl_data['cerobong_id'] = $check2Data['cerobong_id'];

		$send = curl($sandbox_url, $curl_header, json_encode($curl_data));
		$response = json_decode($send, true);
		echo $send;
		$id = $check2Data['id'];
		if ($response['code'] == 200) {
			mysqli_query($con, "update data set status_sispek = 'Terkirim' where id = '$id'");
		}
	}
}
?>
