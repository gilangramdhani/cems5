<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$start =  $_GET['start'];
	$start = str_replace('T', ' ', $start);
	$start = str_replace('+07:00', '', $start);
	$end =  $_GET['end'];
	$end = str_replace('T', ' ', $end);
	$end = str_replace('+07:00', '', $end);
	$calendar = array();
	$query = mysqli_query($con, "select count(id) as title, date(date_start) as start from log_kirim_data where status = 200 and date_start between '$start' and '$end' group by date(date_start)");
	$datas = array();
	while ($datav = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$date = $datav['start'];
		$query2 = mysqli_query($con, "select count(id) as title from log_kirim_data where status <> 200 and date(date_start) = '$date'");
		$value = mysqli_fetch_assoc($query2);
		$data = array();
		$data['title'] = $datav['title'].'/'.$value['title'];
		$data['start'] = $datav['start'];
		$datas[] = $data;
	}
	echo json_encode($datas);
}
?>