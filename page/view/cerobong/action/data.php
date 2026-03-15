<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$cat = input($_GET['cat']);
	$q = input($_GET['q']);
	if ($cat <> 'all') {
		$query = mysqli_query($con, "select * from (select * from data where parameter = '$cat' and cerobong_id = '$q' order by waktu desc limit 25) tmp order by tmp.waktu asc");
		if (mysqli_num_rows($query) > 0 ) {
			$response = array();
			while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$a['x'] = waktu($data['waktu']);
				$a['y'] = $data['value'];
				array_push($response, $a);
			}
			echo json_encode($response);
		}
	}
	if ($cat == 'all') {
		$response = array();
		$parameterallQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
		while ($parameterallData = mysqli_fetch_array($parameterallQuery, MYSQLI_ASSOC)) {
			$parameterall = $parameterallData['parameter_code'];
			$query = mysqli_query($con, "select * from (select * from data where parameter = '$parameterall' and cerobong_id = '$q' order by waktu desc limit 25) tmp order by tmp.waktu asc");
			if (mysqli_num_rows($query) > 0) {
				$a['name'.$parameterallData['parameter_id']] = $parameterallData['parameter_name'].' '.$parameterallData['parameter_portion'];
				$a['type'.$parameterallData['parameter_id']] = 'line';
				while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$a['data'.$parameterallData['parameter_id']][] = $data['value'];
				}
			}
		}
		$parameterwaktuQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active' limit 1");
		$parameterwaktuData = mysqli_fetch_array($parameterwaktuQuery, MYSQLI_ASSOC);
		$parameterwaktu = $parameterwaktuData['parameter_code'];
		$waktuQuery = mysqli_query($con, "select * from (select * from data where parameter = '$parameterwaktu' and cerobong_id = '$q' order by waktu desc limit 25) tmp order by tmp.waktu asc");
		if (mysqli_num_rows($waktuQuery) > 0) {
			while ($waktuData = mysqli_fetch_array($waktuQuery, MYSQLI_ASSOC)) {
				$a['waktu'][] = waktu($waktuData['waktu']);
			}
		}
		array_push($response, $a);
		echo json_encode($response);
	}
}
?>
