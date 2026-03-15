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
		'd.id',
		'c.cerobong_name',
		'd.parameter',
		'd.value',
		'd.waktu',
		'd.laju_alir',
		'd.status',
		'd.fuel',
		'd.load',
		'd.status_sispek'
	);
	$from = 'data d left join cerobong c on d.cerobong_id = c.cerobong_id';
	$primarykey = $primarykey != '' ? $primarykey . ',' : '';
	if ($cat <> 'all') {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.parameter = '$cat' and d.cerobong_id = '$cerobong' and month(d.waktu) = month('$q') and year(d.waktu) = year('$q')";
	}
	if ($cat == 'all') {
		$sql = "SELECT {$primarykey} ".implode(',', $columns)." FROM {$from} WHERE d.parameter in ('".$prm."') and d.cerobong_id = '$cerobong' and month(d.waktu) = month('$q') and year(d.waktu) = year('$q')";
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
			$fields[1] = $row['cerobong_name'];
			$fields[2] = $row['parameter'];
			$fields[3] = $row['value'];
			$fields[4] = waktu($row['waktu']);
			$fields[5] = $row['laju_alir'];
			$fields[6] = $row['status'];
			$fields[7] = $row['fuel'];
			$fields[8] = $row['load'];
			$fields[9] = $row['status_sispek'];
		}
		$datatable['data'][] = $fields;
	}
	$data->close();
	echo json_encode($datatable);
}
?>
