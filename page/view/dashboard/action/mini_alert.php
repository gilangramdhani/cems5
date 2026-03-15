<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	
	$allQuery = mysqli_query($con, "select count(notif_id) as total from notif n left join data d on n.notif_data = d.id where d.status = 'valid'");
	$allData = mysqli_fetch_array($allQuery, MYSQLI_ASSOC);
	$all = $allData['total'];
	
	if ($all <> 0) {
?>
<div class="col-12">
    <p class="alert alert-danger">
		<strong class="text-danger"><?php echo $all; ?> data on threshold.</strong>
		<br>
		<a href="notif/threshold" class="text-danger"><small><i class="feather icon-chevrons-right"></i> View detail</small></a>
	</p>
</div>
<?php
	}
}
?>