<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../config/db.php';
	
	$countQuery = mysqli_query($con, "select count(*) as total from notif n left join data d on n.notif_data = d.id where n.notif_status = 'unread'");
	$allData = mysqli_fetch_array($countQuery, MYSQLI_ASSOC);
	$count = $allData['total'];
	if ($count <> 0) {
		echo '<i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-danger badge-up">'.singkat_angka($count).'</span>';
	}
	if ($count == 0) {
		echo '<i class="ficon feather icon-bell"></i>';
	}
}
mysqli_close($con);
?>
