<?php
date_default_timezone_set("Asia/Makassar");
$myPDO = new PDO("pgsql:host=10.60.26.41;port=5432;dbname=db_das_mti", "postgres", "server12345");
if ($myPDO) {
	//echo 'OK';
}
$now = date('Y-m-d H:i:00');
$sql = "SELECT so2, no, pm, o2, flowrate from table_data_1 order by waktu desc limit 1";
foreach ($myPDO->query($sql) as $row) {
	echo 'so2: '.$row['so2'].'<br>';
	echo 'nox: '.$row['no'].'<br>';
	echo 'pm: '.$row['pm'].'<br>';
	echo 'o2: '.$row['o2'].'<br>';
	echo 'laju_alir: '.$row['flowrate'].'<br>';
	echo 'waktu: '.$now.'<br>';
}

$sql2 = "SELECT cems_status from table_maintenance order by cems_status desc limit 1";
foreach ($myPDO->query($sql2) as $row2) {
	if ($row2['cems_status'] == 0) {
		$status = 'valid';
	}
	if ($row2['cems_status'] == 1) {
		$status = 'maintenance';
	}
	echo 'status: '.$status.'<br>';
	echo 'cerobong_id: 1';
}
?>
