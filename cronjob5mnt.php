<?php
//header('refresh:300; url=cronjob5mnt.php');
include 'page/config/db.php';
mysqli_query($con, "SET sql_mode = ''");
$waktu = date('Y-m-d H:i:00',strtotime(date('Y-m-d H:i:00').' -5 minutes'));
$query = mysqli_query($con, "select * from cerobong");
while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$cerobong_id = $data['cerobong_id'];
	$cerobong_from = $data['cerobong_from'];
	$cerobong_to = $data['cerobong_to'];
	$cerobong_status = $data['cerobong_status'];
	// cek status cerobong
	if ($cerobong_from <> null && $cerobong_to <> null) {
		if ($waktu >= $cerobong_from && $waktu < $cerobong_to) {
			$cerobong_status = $data['cerobong_schedule'];
			mysqli_query($con, "update cerobong set cerobong_status = '$cerobong_status' where cerobong_id = '$cerobong_id'");
		}
		if ($waktu >= $cerobong_to) {
			$cerobong_status = 'active';
			mysqli_query($con, "update cerobong set cerobong_status = '$cerobong_status', cerobong_schedule = '', cerobong_from = null, cerobong_to = null where cerobong_id = '$cerobong_id'");
		}
	}
	$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
	while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
		$parameter = $parameterData['parameter_code'];
		// cek status cerobong
		if ($cerobong_status <> 'active') {
			$value = 1;
			if($cerobong_status == 'rusak'){
				$value = 0;
			}
			$velocity = 1;
			$laju_alir = 1;
			$status_gas = $cerobong_status;
			$status_partikulat = $cerobong_status;
			$status = $cerobong_status;
			$fuel = '';
			$load = 1;
			//mysqli_query($con, "insert ignore into data (parameter, value, waktu, velocity, laju_alir, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at) values ('$parameter', '$value', '$waktu', '$velocity', '$laju_alir', '$status_gas', '$status_partikulat', '$status', '$fuel', '$load', $cerobong_id, NOW())");
		}
		if ($cerobong_status == 'active') {
			// cek data 5 menit lalu
			$checkQuery = mysqli_query($con, "select * from data where parameter = '$parameter' and cerobong_id = '$cerobong_id' and DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') = '$waktu'");
			echo mysqli_num_rows($checkQuery); 
			if (mysqli_num_rows($checkQuery) == 0) {
				mysqli_query($con, "insert ignore into temp_table (temp_parameter, temp_waktu, temp_cerobong) values ('$parameter', '$waktu', '$cerobong_id')");
			}
		}
	}
}
?>
