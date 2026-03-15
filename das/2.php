<?php
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

$sandbox_url = 'http://localhost/cems/sandbox/index.php';
$client_id = '36a3f70e918248671c438a81d478bf6c';
$secret_id = 'ed472d1bce3ed19f131f9feb8b9f4a77a3f29923f85648a27e3484c4e103bbc0';
$key = md5($client_id.$secret_id);
$curl_header = array(
	"key:$key"
);
$curl_data = array();

$myPDO = new PDO("pgsql:host=10.60.27.106;port=5432;dbname=db_das_mti", "postgres", "server12345");
$now = date('Y-m-d H:i:00');
$sql = "SELECT so2, no, pm, o2, co2, temperature, flowrate from table_data_1 order by waktu desc limit 1";

foreach ($myPDO->query($sql) as $row) {
	$curl_data['SO2'] = $row['so2'];
	$curl_data['NOx'] = $row['no'];
	$curl_data['PM'] = $row['pm'];
	$curl_data['O2'] = $row['o2'];
	$curl_data['CO2'] = $row['co2'];
	$curl_data['Temp'] = $row['temperature'];
	$curl_data['laju_alir'] = $row['flowrate'];
	$curl_data['waktu'] = $now;
}

$sql2 = "SELECT cems_status from table_maintenance order by cems_status desc limit 1";
foreach ($myPDO->query($sql2) as $row2) {
	if ($row2['cems_status'] == 0) {
		$status = 'valid';
	}
	if ($row2['cems_status'] == 1) {
		$status = 'maintenance';
	}
	$curl_data['status'] = $status;
	$curl_data['status_gas'] = $status;
	$curl_data['status_partikulat'] = $status;
	$curl_data['fuel'] = '';
	$curl_data['load'] = 0;
	$curl_data['cerobong_id'] = 2;
}
$send = curl($sandbox_url, $curl_header, json_encode($curl_data));
$response = json_decode($send, true);
echo $send;
echo json_encode($curl_data);
?>

