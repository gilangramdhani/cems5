<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$tahun = input($_GET['tahun']);
	$q = date('Y-m-d', strtotime(input('01/01/'.$tahun)));
	$cerobong = input($_GET['cerobong']);
	$cat = input($_GET['cat']);
	$prm = implode("','",json_decode(stripslashes($_GET['prm'])));
	if ($cat <> 'all') {
		$query = mysqli_query($con, "select avg(value) as y, month(waktu) as x from data where parameter = '$cat' and cerobong_id = '$cerobong' and date_sub(waktu, interval 1 month) and year(waktu) = year('$q') group by month(waktu) order by month(waktu) asc");
		if (mysqli_num_rows($query) > 0) {
			$response = array();
			while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$a['x'] = 'Bulan '.$data['x'];
				$a['y'] = round($data['y'], 2);
				array_push($response, $a);
			}
			echo json_encode($response);
		}
	}
	if ($cat == 'all') {
		$response = array();
		$parameterallQuery = mysqli_query($con, "select * from parameter where parameter_code in ('".$prm."')");
		$no = 0;
		while ($parameterallData = mysqli_fetch_array($parameterallQuery, MYSQLI_ASSOC)) {
			$no++;
			$parameterall = $parameterallData['parameter_code'];
			$query = mysqli_query($con, "select avg(value) as y, month(waktu) as x from data where parameter = '$parameterall' and cerobong_id = '$cerobong' and date_sub(waktu, interval 1 month) and year(waktu) = year('$q') group by month(waktu) order by month(waktu) asc");
			if (mysqli_num_rows($query) > 0) {
				$a['name'.$no] = $parameterallData['parameter_name'];
				$a['type'.$no] = 'line';
				while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$a['data'.$no][] = round($data['y'], 2);
				}
			}
		}
		$parameterwaktuQuery = mysqli_query($con, "select * from parameter where parameter_code in ('".$prm."') limit 1");
		$parameterwaktuData = mysqli_fetch_array($parameterwaktuQuery, MYSQLI_ASSOC);
		$parameterwaktu = $parameterwaktuData['parameter_code'];
		$waktuQuery = mysqli_query($con, "select avg(value) as y, month(waktu) as x from data where parameter = '$parameterwaktu' and cerobong_id = '$cerobong' and date_sub(waktu, interval 1 month) and year(waktu) = year('$q') group by month(waktu) order by month(waktu) asc");
		if (mysqli_num_rows($waktuQuery) > 0) {
			while ($waktuData = mysqli_fetch_array($waktuQuery, MYSQLI_ASSOC)) {
				//$a['waktu'][] = tanggal($waktuData['x']);
				$a['waktu'][] = $waktuData['x'];
			}
		}
		array_push($response, $a);
		echo json_encode($response);
	}
}
?>