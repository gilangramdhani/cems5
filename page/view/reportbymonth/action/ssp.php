<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$bulan = input($_GET['bulan']);
	$tahun = input($_GET['tahun']);
	$q = date('Y-m-d', strtotime(input($bulan.'/01/'.$tahun)));
	$cerobong = input($_GET['cerobong']);
	$cat = input($_GET['cat']);
	$prm = implode("','",json_decode(stripslashes($_GET['prm'])));
	$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$primarykey = 'id';
	$columns = array(
		'a.id',
		'a.tanggal',
		'a.concentrate',
		'a.threshold',
		'p.parameter_portion',
		'a.laju_alir',
		'a.debit',
		'a.waktu',
		'a.total'
	);
	$from = 'asahimas_report a left join parameter p on a.parameter = p.parameter_code';
	$primarykey = $primarykey != '' ? $primarykey . ',' : '';
	if ($cat <> 'all') {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE a.parameter = '$cat' and a.cerobong = '$cerobong' and month(a.tanggal) = month('$q') and year(a.tanggal) = year('$q')";
	}
	if ($cat == 'all') {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE a.parameter in ('".$prm."') and a.cerobong = '$cerobong' and month(a.tanggal) = month('$q') and year(a.tanggal) = year('$q')";
	}
	if (isset($_GET['search']['value']) && $_GET['search']['value'] != '') {
		$search = $_GET['search']['value'];
		$where  = '';
		for ($i = 0; $i < count($columns); $i++) {
			$where .= $columns[$i].' LIKE "%'.$search.'%"';
			if ($i < count($columns) -1) {
				$where .= " OR ";
			}
		}
		$sql .= " AND (".$where.")";
	}
	$sortColumn = isset($_GET['order'][0]['column']) ? $_GET['order'][0]['column'] : 0;
	$sortDir = isset($_GET['order'][0]['dir']) ? $_GET['order'][0]['dir'] : 'asc';
	$sortColumn = $columns[$sortColumn];
	$sql .= " ORDER BY {$sortColumn} {$sortDir}";
	$count = $database->query($sql);
	$totaldata = $count->num_rows;
	$count->close();
	$start  = isset($_GET['start']) ? $_GET['start'] : 0;
	$length = isset($_GET['length']) ? $_GET['length'] : 10;
	$sql .= " LIMIT {$start}, {$length}";
	$data = $database->query($sql);
	$datatable['draw'] = isset($_GET['draw']) ? $_GET['draw'] : 1;
	$datatable['recordsTotal'] = $totaldata;
	$datatable['recordsFiltered'] = $totaldata;
	$datatable['data'] = array();
	while ($row = $data->fetch_assoc()) {
		$fields = array();
		for ($i = 0; $i < count($columns); $i++) {
			$fields[0] = $row['id'];
			$fields[1] = tanggal($row['tanggal']);
			$fields[2] = $row['concentrate'];
			$fields[3] = $row['threshold'];
			$fields[4] = $row['parameter_portion'];
			$fields[5] = $row['laju_alir'];
			$fields[6] = $row['debit'];
			$fields[7] = $row['waktu'];
			$fields[8] = $row['total'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>