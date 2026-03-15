<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$primarykey = 'cerobong_id';
	$columns = array(
		'cerobong_name',
		'cerobong_status',
		'cerobong_schedule',
		'cerobong_from',
		'cerobong_to',
		'cerobong_user',
		'cerobong_id'
	);
	$from = 'cerobong';
	$primarykey = $primarykey != '' ? $primarykey . ',' : '';
	$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE 1 = 1";
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
			$fields[0] = $row['cerobong_id'];
			$fields[1] = $row['cerobong_name'];
			$fields[2] = $row['cerobong_status'];
			$fields[3] = $row['cerobong_schedule'];
			$fields[4] = $row['cerobong_from'];
			$fields[5] = $row['cerobong_to'];
			$fields[6] = $row['cerobong_user'];
			$fields[7] = $row['cerobong_id'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>
