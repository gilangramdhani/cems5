<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$q = input($_GET['q']);
    $monthsago = date('Y-m-d', strtotime('-3 months'));
	$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    $count = $database->query("SET sql_mode = ''");
    $sql = "SELECT CONCAT(HOUR(waktu), ':00-', HOUR(waktu)+1, ':00') AS hours, DATE_FORMAT(waktu,'%Y-%m-%d') AS tanggal, status_sispek FROM data WHERE waktu BETWEEN '$monthsago' AND NOW() AND cerobong_id = '$q' GROUP BY HOUR(waktu), date(waktu), month(waktu), status_sispek ORDER BY waktu DESC";
	//$sortColumn = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 0;
	//$sortDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';
	//$sortColumn = $columns[$sortColumn];
	//$sql .= " ORDER BY {$sortColumn} {$sortDir}";
	//count
    $sql_count = "SELECT CONCAT(HOUR(waktu), ':00-', HOUR(waktu)+1, ':00') AS hours, DATE_FORMAT(waktu,'%Y-%m-%d') AS tanggal, status_sispek FROM data WHERE waktu BETWEEN '$monthsago' AND NOW() AND cerobong_id = '$q' GROUP BY HOUR(waktu), date(waktu), month(waktu), status_sispek";
    //echo $sql_count;
	//$count = $database->query($sql_count);
	//$totaldata_count = $count->fetch_assoc();
	//$totaldata = $totaldata_count['total'];
	//count
	$count = $database->query($sql_count);
	$totaldata = $count->num_rows;
	$count->close();
	$start  = isset($_GET['start']) ? $_GET['start'] : 0;
	$length = isset($_GET['length']) ? $_GET['length'] : 10;
	$sql .= " LIMIT {$start}, {$length}";
    //echo $sql;
	$data = $database->query($sql);
	$datatable['draw'] = isset($_GET['draw']) ? $_GET['draw'] : 1;
	$datatable['recordsTotal'] = $totaldata;
	$datatable['recordsFiltered'] = $totaldata;
	$datatable['data'] = array();
    //var_dump($data);
	while ($row = $data->fetch_assoc()) {
        //echo $row['hours'];
		$fields = array();
		for ($i = 0; $i < 3; $i++) {
			$fields[0] = $row['tanggal'];
			$fields[1] = $row['hours'];
			$fields[2] = $row['status_sispek'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>
