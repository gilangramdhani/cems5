<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$q = $_GET['q'];
	$q_array = array('all_data', 'valid', 'invalid', 'calibrate', 'maintenance', 'threshold');
	$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$primarykey = 'id';
	$columns = array(
		'd.id',
		'd.cerobong_id',
		'p.parameter_name',
		'd.value',
		'd.waktu',
		'd.velocity',
		'd.status_gas',
		'd.status_partikulat',
		'd.status',
		'd.fuel',
		'd.load',
		'd.status_sispek'
	);
	if ($q == 'all_data') {
		$from = 'data d left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE 1 = 1";
	}
	if ($q == 'valid') {
		$from = 'data d left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.status = 'valid'";
	}
	if ($q == 'invalid') {
		$from = 'data d left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.status = 'invalid'";
	}
	if ($q == 'calibrate') {
		$from = 'data d left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.status = 'calibrate'";
	}
	if ($q == 'maintenance') {
		$from = 'data d left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.status = 'maintenance'";
	}
	if ($q == 'threshold') {
		$from = 'notif n left join data d on n.notif_data = d.id left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.status = 'valid'";
	}
	if (!in_array($q, $q_array)) {
		$from = 'data d left join parameter p on d.parameter = p.parameter_code';
		$primarykey = $primarykey != '' ? $primarykey . ',' : '';
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.id = '$q'";
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
	//count
	$pecah = explode(' ',$sql);
	$sql_count = $pecah[0].' count(*) as total';
	for ($x = 3; $x < count($pecah); $x++) {
		$sql_count .= ' '.$pecah[$x];
	}
	$count = $database->query($sql_count);
	$totaldata_count = $count->fetch_assoc();
	$totaldata = $totaldata_count['total'];
	//count
	//$count = $database->query($sql);
	//$totaldata = $count->num_rows;
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
		$cerobong_id = $row['cerobong_id'];
		$cerobongQuery = mysqli_query($con, "select * from cerobong where cerobong_id = '$cerobong_id'");
		$cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC);
		$cerobong = $cerobongData['cerobong_name'];
		$fields = array();
		for ($i = 0; $i < count($columns); $i++) {
			$fields[0] = $row['id'];
			$fields[1] = $cerobong;
			$fields[2] = $row['parameter_name'];
			$fields[3] = $row['value'];
			$fields[4] = waktu($row['waktu']);
			$fields[5] = $row['velocity'];
			$fields[6] = $row['status_gas'];
			$fields[7] = $row['status_partikulat'];
			$fields[8] = $row['status'];
			$fields[9] = $row['fuel'];
			$fields[10] = $row['load'];
			$fields[11] = $row['status_sispek'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>
