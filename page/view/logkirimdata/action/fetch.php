<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		if ($action == 'detail') {
			$id = $_POST['id'];
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Detail Log Kirim Data : <?php echo tanggal($id); ?></h4>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><button id="close_btn" type="button" class="btn btn-icon btn-flat-danger"><i class="feather icon-x"></i></button></li>
			</ul>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table nowrap">
					<thead>
						<tr>
							<th><center>Date Start</center></th>
							<th><center>Status</center></th>
							<th><center>Log</center></th>
							<th><center>Waktu Pengiriman</center></th>
						</tr>
					</thead>
					<tbody>
<?php
			$no = 0;
			$query = mysqli_query($con, "select * from log_kirim_data where date(date_start) = '$id'");
			while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$no++;
?>
						<tr>
							<td><center><?php echo waktu($data['date_start']); ?></center></td>
							<td><center><?php echo $data['status']; ?></center></td>
							<td><center><?php echo $data['log']; ?></center></td>
							<td><center><?php echo $data['updated_at']; ?></center></td>
						</tr>
<?php
			}
?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}
}
?>