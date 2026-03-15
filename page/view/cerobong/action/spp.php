<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$q = input($_GET['q']);
	$database = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$primarykey = 'id';
	$columns = array(
		'd.id',
		'p.parameter_name',
		'd.value',
		'd.waktu',
		'd.laju_alir',
		'd.status_gas',
		'd.status_partikulat',
		'd.status',
		'd.fuel',
		'd.load',
		'd.status_sispek'
	);
	$from = 'data d left join parameter p on d.parameter = p.parameter_code';
	$primarykey = $primarykey != '' ? $primarykey . ',' : '';
	$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE cerobong_id = '$q'";
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
			$fields[1] = $row['parameter_name'];
			$fields[2] = $row['value'];
			$fields[3] = waktu($row['waktu']);
			$fields[4] = $row['laju_alir'];
			$fields[5] = $row['status'];
			$fields[6] = $row['fuel'];
			$fields[7] = $row['status_sispek'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>
