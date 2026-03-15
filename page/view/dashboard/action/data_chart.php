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
				$query = mysqli_query($con, "select * from (select * from data where parameter = 'SO2' and cerobong_id = '$cerobong_id' order by id desc limit 1) tmp order by tmp.waktu asc");
			}else{
				$query = mysqli_query($con, "select * from (select * from data where parameter = '$q' and cerobong_id = '$cerobong_id' order by id desc limit 1) tmp order by tmp.waktu asc");
			}
			if (mysqli_num_rows($query) > 0 ) {
				$a['name'.$cerobongData['cerobong_id']] = $cerobongData['cerobong_name'];
				while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					if($q=='flow'){
						$a['data'.$cerobongData['cerobong_id']] = $data['laju_alir'];
					}else{
						$a['data'.$cerobongData['cerobong_id']] = $data['value'];
					}
				}
			}
		}
		array_push($response, $a);
		echo json_encode($response);
	}
}
?>