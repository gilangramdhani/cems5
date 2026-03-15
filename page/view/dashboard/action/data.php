<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$cat = $_GET['cat'];
	$q = $_GET['q'];
	if ($cat == 'param') {
		$response = array();
		$cerobongQuery = mysqli_query($con, "select * from cerobong");
		while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
			$cerobong_id = $cerobongData['cerobong_id'];
			if($q=='flow'){
				$query = mysqli_query($con, "select * from (select * from data where parameter = 'SO2' and cerobong_id = '$cerobong_id' order by id desc limit 7) tmp order by tmp.waktu asc");
			}else{
				$query = mysqli_query($con, "select * from (select * from data where parameter = '$q' and cerobong_id = '$cerobong_id' order by id desc limit 7) tmp order by tmp.waktu asc");
			}
			if (mysqli_num_rows($query) > 0 ) {
				$a['name'.$cerobongData['cerobong_id']] = $cerobongData['cerobong_name'];
				while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					if($q=='flow'){
						$a['data'.$cerobongData['cerobong_id']][] = $data['laju_alir'];
					}else{
						$a['data'.$cerobongData['cerobong_id']][] = $data['value'];
					}
				}
			}
		}
		if($q=='flow'){
			$waktuQuery = mysqli_query($con, "select * from (select * from data where parameter = 'SO2' and cerobong_id = 1 order by id desc limit 7) tmp order by tmp.waktu asc");
		}else{
			$waktuQuery = mysqli_query($con, "select * from (select * from data where parameter = '$q' and cerobong_id = 1 order by id desc limit 7) tmp order by tmp.waktu asc");
		}
		if (mysqli_num_rows($waktuQuery) > 0 ) {
			while ($waktuData = mysqli_fetch_array($waktuQuery, MYSQLI_ASSOC)) {
				$a['waktu'][] = waktu($waktuData['waktu']);
			}
		}
		array_push($response, $a);
		echo json_encode($response);
	}
	if ($cat == 'all') {
		$response = array();
		$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
		while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
			$parameter = $parameterData['parameter_code'];
			$query = mysqli_query($con, "select * from (select * from data where parameter = '$parameter' and cerobong_id = '$q' order by id desc limit 25) tmp order by tmp.waktu asc");
			if (mysqli_num_rows($query) > 0 ) {
				$a['name'.$parameterData['parameter_id']] = $parameterData['parameter_name'].' '.$parameterData['parameter_portion'];
				$a['type'.$parameterData['parameter_id']] = 'line';
				while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$a['data'.$parameterData['parameter_id']][] = $data['value'];
				}
			}
		}
		$a['nameflow'] = 'Flow m3/s';
		$a['typeflow'] = 'line';
		$query = mysqli_query($con, "select * from (select * from data where parameter = 'SO2' and cerobong_id = '$q' order by id desc limit 25) tmp order by tmp.waktu asc");
		while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$a['dataflow'][] = $data['laju_alir'];
		}
		$parameterwaktuQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active' limit 1");
		$parameterwaktuData = mysqli_fetch_array($parameterwaktuQuery, MYSQLI_ASSOC);
		$parameterwaktu = $parameterwaktuData['parameter_code'];
		$waktuQuery = mysqli_query($con, "select * from (select * from data where parameter = '$parameterwaktu' and cerobong_id = '$q' order by id desc limit 25) tmp order by tmp.waktu asc");
		if (mysqli_num_rows($waktuQuery) > 0 ) {
			while ($waktuData = mysqli_fetch_array($waktuQuery, MYSQLI_ASSOC)) {
				$a['waktu'][] = waktu($waktuData['waktu']);
			}
		}
		array_push($response, $a);
		echo json_encode($response);
	}
}
?>