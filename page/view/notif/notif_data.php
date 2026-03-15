<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../config/db.php';
	$dataQuery = mysqli_query($con, "select * from notif n left join data d on n.notif_data = d.id left join parameter p on d.parameter = p.parameter_code order by d.waktu desc limit 5");
	
	if (mysqli_num_rows($dataQuery) <> 0) {
		while ($dataData = mysqli_fetch_array($dataQuery, MYSQLI_ASSOC)) {
?>
<a class="d-flex justify-content-between" href="notif/<?php echo $dataData['notif_data']; ?>">
	<div class="media d-flex align-items-start">
<?php
			if ($dataData['status'] == 'invalid') {
?>
		<div class="media-left"><i class="feather icon-alert-circle font-medium-5 secondary"></i></div>
		<div class="media-body">
			<h6 class="secondary media-heading">New invalid data</h6>
		</div>
<?php
			}
			if ($dataData['status'] == 'calibrate') {
?>
		<div class="media-left"><i class="feather icon-alert-circle font-medium-5 warning"></i></div>
		<div class="media-body">
			<h6 class="warning media-heading">New calibrate data</h6>
		</div>
<?php
			}
			if ($dataData['status'] == 'maintenance') {
?>
		<div class="media-left"><i class="feather icon-x-circle font-medium-5 danger"></i></div>
		<div class="media-body">
			<h6 class="danger media-heading">New maintenance data</h6>
		</div>
<?php
			}
			$status_array = array('invalid', 'calibrate', 'maintenance');
			if (!in_array($dataData['status'], $status_array)) {
				$valCheck = $dataData['parameter_threshold'];
				$value = $dataData['value'];
				if ($value < $valCheck) {
?>
		<div class="media-left"><i class="feather icon-alert-circle font-medium-5 primary"></i></div>
		<div class="media-body">
			<h6 class="primary media-heading">The data is approaching the threshold</h6>
		</div>
<?php
				}
				if ($value == $valCheck) {
?>
		<div class="media-left"><i class="feather icon-alert-circle font-medium-5 primary"></i></div>
		<div class="media-body">
			<h6 class="primary media-heading">Data are at threshold</h6>
		</div>
<?php
				}
				if ($value > $valCheck) {
?>
		<div class="media-left"><i class="feather icon-alert-circle font-medium-5 primary"></i></div>
		<div class="media-body">
			<h6 class="primary media-heading">Data exceeds threshold</h6>
		</div>
<?php
				}
			}
?>
		<small class="text-right"><time class="media-meta"><?php echo tanggal($dataData['waktu']); ?><br><?php echo jam($dataData['waktu']); ?></time></small>
	</div>
</a>
<?php
		}
	}
}
?>