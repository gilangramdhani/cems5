<?php
include '../page/config/db.php';

include '../KLHKFunction.php';
//if (isset($_SERVER['HTTP_KEY'])) {
	$response = array();
	//$key = $_SERVER['HTTP_KEY'];
	//$client_idQuery = mysqli_query($con, "select * from config where config_name = 'client_id'");
	//$client_idData = mysqli_fetch_array($client_idQuery, MYSQLI_ASSOC);
	//$client_id = $client_idData['config_value'];
	//$secret_idQuery = mysqli_query($con, "select * from config where config_name = 'secret_id'");
	//$secret_idData = mysqli_fetch_array($secret_idQuery, MYSQLI_ASSOC);
	//$secret_id = $secret_idData['config_value'];
	//$check = md5($client_id.$secret_id);
	//if ($key == $check) {
		$data = json_decode(file_get_contents('php://input'), true);
		//tangkep
		//$tangkep = file_get_contents('php://input');
		//$myfile = fopen('cerobong_'.$data['cerobong_id'].'.json', 'w') or die('Unable to open file!');
		//fwrite($myfile, $tangkep);
		//fclose($myfile);
		//tangkep
		//if (!isset($data['NOx'], $data['SO2'], $data['PM'], $data['CO2'], $data['Hg'], $data['O2'], $data['waktu'], $data['velocity'], $data['status_gas'], $data['status_partikulat'], $data['status'], $data['fuel'], $data['load'], $data['cerobong_id'])) {
		//	$response['code'] = 400;
		//	$response['status'] = 'Format json data Anda salah.';
		//}
		//if (isset($data['NOx'], $data['SO2'], $data['PM'], $data['CO2'], $data['Hg'], $data['O2'], $data['waktu'], $data['velocity'], $data['status_gas'], $data['status_partikulat'], $data['status'], $data['fuel'], $data['load'], $data['cerobong_id'])) {
			$klhk = new KLHKFunction();
    		$o2_threshold = $klhk->getconfig($con, 'o2_threshold');

			$waktu = $data['waktu'];
			$cerobong_id = $data['cerobong_id'];
			$cerobongQuery = mysqli_query($con, "select * from cerobong where cerobong_id = '$cerobong_id'");
			if (mysqli_num_rows($cerobongQuery) == 0) {
				$response['code'] = 404;
				$response['status'] = 'Cerobong tidak ditemukan.';
			}
			if (mysqli_num_rows($cerobongQuery) <> 0) {
				//update 12/05/2021
				$cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC);
				$cerobong_status = $cerobongData['cerobong_status'];
				$cerobong_schedule = $cerobongData['cerobong_schedule'];
				$cerobong_from = $cerobongData['cerobong_from'];
				$cerobong_to = $cerobongData['cerobong_to'];
				if ($cerobong_schedule != '' && $waktu >= $cerobong_from && $waktu < $cerobong_to) {
					$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
					while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
						$parameter = $parameterData['parameter_code'];
						$bakumutu = $parameterData['parameter_threshold'];
						if ($cerobong_schedule == 'maintenace' || $cerobong_schedule == 'calibrate'){
							$value = 1;
							$laju_alir = 1;
						}else{
							$value = 0;
							$laju_alir = 0;
						}
						$velocity = 0;
						$status_gas = $cerobong_schedule;
						$status_partikulat = $cerobong_schedule;
						$status = $cerobong_schedule;
						$fuel = $data['fuel'];
						$load = 1;
						mysqli_query($con, "insert ignore into data (parameter, value, waktu, velocity, laju_alir, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at) values ('$parameter', '$value', '$waktu', '$velocity', '$laju_alir', '$status_gas', '$status_partikulat', '$status', '$fuel', '$load', $cerobong_id, NOW())");
					}
				}else{
					$mail_execute = 'no';
					$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
					while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
						$parameter = $parameterData['parameter_code'];
						$bakumutu = $parameterData['parameter_threshold'];
						$value = $data[$parameter];
						$velocity = 0;
						//$debit = $velocity / 3600;
						$laju_alir = $data['laju_alir'];
						$status_gas = $data['status_gas'];
						$status_partikulat = $data['status_partikulat'];
						$status = $data['status'];
						$fuel = $data['fuel'];
						$load = $data['load'];
						if ($value > $bakumutu){
							$value = 1;
							$laju_alir = 1;
						}
						if ($data['O2'] > $o2_threshold) {
							if ($value != 'O2'){
								$value = 1;
								$laju_alir = 1;
								$status_gas = 'maintenance';
								$status_partikulat = 'maintenance';
								$status = 'maintenance';
							}
						}
						if ($value <= 0) {
							$value = 1;
							$laju_alir = 1;
							$status_gas = 'valid';
							$status_partikulat = 'valid';
							$status = 'valid';
							$fuel = $data['fuel'];
							$load = 0;
						}
						$parameter_id = $parameterData['id'];
						$paramterStatus = mysqli_query($con, "select * from parameter_cerobong_status where id_parameter = '$parameter_id' and id_cerobong = '$cerobong_id'");
						while ($status_parameter = mysqli_fetch_array($paramterStatus, MYSQLI_ASSOC)) {
							if($status_parameter['status'] == 'maintenance' || $status_parameter['status'] == 'calibrate'){
								$value = 1; 
							}elseif($status_parameter['status'] == 'rusak') {
								$value = 0;
							}
						}
						$checkQuery = mysqli_query($con, "select * from data where parameter = '$parameter' and cerobong_id = '$cerobong_id' and DATE_FORMAT(waktu, '%Y-%m-%d %H:%i:00') = '$waktu'");
						if (mysqli_num_rows($checkQuery) == 0) {
							mysqli_query($con, "insert ignore into data (parameter, value, waktu, velocity, laju_alir, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at) values ('$parameter', '$value', '$waktu', '$velocity', '$laju_alir', '$status_gas', '$status_partikulat', '$status', '$fuel', '$load', '$cerobong_id', NOW())");
							$notif_data = mysqli_insert_id($con);
						}
						if (mysqli_num_rows($checkQuery) <> 0) {
							$checkData = mysqli_fetch_array($checkQuery, MYSQLI_ASSOC);
							$notif_data = $checkData['id'];
							mysqli_query($con, "update data set value = '$value', velocity = '$velocity', laju_alir = '$laju_alir', status_gas = '$status_gas', status_partikulat = '$status_partikulat', status = '$status', fuel = '$fuel', `load` = '$load', modified_at = NOW() where id = '$notif_data'");
						}
						//notif
						$threshold = $parameterData['parameter_threshold'];
						$valCheck = $threshold - ($threshold * 0.1);
						if ($status <> 'valid' or $value >= $valCheck) {
							$notif_status = 'unread';
							mysqli_query($con, "insert ignore into notif (notif_data, notif_status) values ('$notif_data', '$notif_status')");
						}
					}
				}
				$response['code'] = 200;
				$response['status'] = 'Success.';
				// update 12/05/2021
			}
		//}
	//}
	//if ($key <> $check) {
	//	$response['code'] = 401;
	//	$response['status'] = 'Session key Anda salah.';
	//}
	mysqli_close($con);
	echo json_encode($response);
//}
?>
