<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$q = $_GET['q'];
	$user_id = $_SESSION['id'];
	$cat_array = array('troubleshoot', 'service', 'maintenance');
	$status_array = array('', 'star', 'trash', 'complete');
	$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$primarykey = 'activity_id';
	$columns = array(
		'activity_id',
		'activity_title',
		'activity_cat',
		'activity_desc',
		'activity_status',
		'created_at'
	);
	$from = 'activity';
	$primarykey = $primarykey != '' ? $primarykey . ',' : '';
	if ($q == 'all') {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE activity_status <> 'trash'";
	}
	if (in_array($q, $cat_array)) {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE activity_status <> 'trash' and activity_cat = '$q'";
	}
	if (in_array($q, $status_array)) {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE activity_status = '$q'";
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
			$fields[0] = $row['activity_id'];
			$fields[1] = $row['activity_title'];
			$fields[2] = $row['activity_cat'];
			$fields[3] = substr($row['activity_desc'], 0, 100);
			$fields[4] = $row['activity_status'];
			$fields[5] = waktu($row['created_at']);
			$fields[6] = $row['activity_id'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>