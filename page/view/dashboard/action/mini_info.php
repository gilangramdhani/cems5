<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
?>
<div class="col-12 col-md-2">
<?php
	$host = 'ppmu.kemenlh.go.id';
	if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
?>
	<div class="card text-center bg-success">
		<div class="card-content">
			<div class="card-body">
				<div class="avatar bg-white p-50 m-0 mb-1">
					<div class="avatar-content">
						<i class="feather icon-check text-success font-medium-5"></i>
					</div>
				</div>
				<h2 class="text-bold-700 text-white">Online</h2>
				<p class="mb-0 line-ellipsis text-white">Status</p>
			</div>
		</div>
	</div>
<?php
	fclose($socket);
	} else {
?>
	<div class="card text-center bg-danger">
		<div class="card-content">
			<div class="card-body">
				<div class="avatar bg-white p-50 m-0 mb-1">
					<div class="avatar-content">
						<i class="feather icon-x text-danger font-medium-5"></i>
					</div>
				</div>
				<h2 class="text-bold-700 text-white">Offline</h2>
				<p class="mb-0 line-ellipsis text-white">Status</p>
			</div>
		</div>
	</div>
<?php
	}
?>
</div>
<!--
<div class="col-12 col-md-2">
	<div class="card text-center">
		<div class="card-content">
			<div class="card-body">
				<div class="avatar p-50 m-0 mb-1">
					<div class="avatar-content">
						<i class="feather icon-database font-medium-5"></i>
					</div>
				</div>
<?php
$cerobongQuery = mysqli_query($con, "select cerobong_id from cerobong");
?>
				<h2 class="text-bold-700"><?php echo mysqli_num_rows($cerobongQuery); ?></h2>
				<p class="mb-0 line-ellipsis">Cerobong</p>
			</div>
		</div>
	</div>
</div>
-->
<div class="col-12 col-md-2">
	<a href="notif/all_data">
		<div class="card text-center">
			<div class="card-content">
				<div class="card-body">
					<div class="avatar bg-rgba-primary p-50 m-0 mb-1">
						<div class="avatar-content">
							<i class="feather icon-globe text-primary font-medium-5"></i>
						</div>
					</div>
<?php
$totalQuery = mysqli_query($con, "select count(id) as total from data");
$totalData = mysqli_fetch_array($totalQuery, MYSQLI_ASSOC);
$totalCount = $totalData['total'];
?>
					<h2 class="text-bold-700 text-primary"><?php echo singkat_angka($totalCount); ?></h2>
					<p class="mb-0 line-ellipsis text-primary">Total Data</p>
				</div>
			</div>
		</div>
	</a>
</div>
<div class="col-12 col-md-2">
	<a href="notif/valid">
		<div class="card text-center">
			<div class="card-content">
				<div class="card-body">
					<div class="avatar bg-rgba-success p-50 m-0 mb-1">
						<div class="avatar-content">
							<i class="feather icon-check-circle text-success font-medium-5"></i>
						</div>
					</div>
<?php
$validQuery = mysqli_query($con, "select count(id) as total from data where status = 'valid'");
$validData = mysqli_fetch_array($validQuery, MYSQLI_ASSOC);
$validCount = $validData['total'];
?>
					<h2 class="text-bold-700 text-success"><?php echo singkat_angka($validCount); ?></h2>
					<p class="mb-0 line-ellipsis text-success">Valid</p>
				</div>
			</div>
		</div>
	</a>
</div>
<div class="col-12 col-md-2">
	<a href="notif/invalid">
		<div class="card text-center">
			<div class="card-content">
				<div class="card-body">
					<div class="avatar bg-rgba-muted p-50 m-0 mb-1">
						<div class="avatar-content">
							<i class="feather icon-alert-circle text-default font-medium-5"></i>
						</div>
					</div>
<?php
$invalidQuery = mysqli_query($con, "select count(id) as total from data where status = 'invalid'");
$invalidData = mysqli_fetch_array($invalidQuery, MYSQLI_ASSOC);
$invalidCount = $invalidData['total'];
?>
					<h2 class="text-bold-700 text-muted"><?php echo singkat_angka($invalidCount); ?></h2>
					<p class="mb-0 line-ellipsis text-muted">Invalid</p>
				</div>
			</div>
		</div>
	</a>
</div>
<div class="col-12 col-md-2">
	<a href="notif/calibrate">
		<div class="card text-center">
			<div class="card-content">
				<div class="card-body">
					<div class="avatar bg-rgba-warning p-50 m-0 mb-1">
						<div class="avatar-content">
							<i class="feather icon-crosshair text-warning font-medium-5"></i>
						</div>
					</div>
<?php
$calibrateQuery = mysqli_query($con, "select count(id) as total from data where status = 'calibrate'");
$calibrateData = mysqli_fetch_array($calibrateQuery, MYSQLI_ASSOC);
$calibrateCount = $calibrateData['total'];
?>
					<h2 class="text-bold-700 text-warning"><?php echo singkat_angka($calibrateCount); ?></h2>
					<p class="mb-0 line-ellipsis text-warning">Calibrate</p>
				</div>
			</div>
		</div>
	</a>
</div>
<div class="col-12 col-md-2">
	<a href="notif/maintenance">
		<div class="card text-center">
			<div class="card-content">
				<div class="card-body">
					<div class="avatar bg-rgba-danger p-50 m-0 mb-1">
						<div class="avatar-content">
							<i class="feather icon-x-circle text-danger font-medium-5"></i>
						</div>
					</div>
<?php
$maintenanceQuery = mysqli_query($con, "select count(id) as total from data where status = 'maintenance'");
$maintenanceData = mysqli_fetch_array($maintenanceQuery, MYSQLI_ASSOC);
$maintenanceCount = $maintenanceData['total'];
?>
					<h2 class="text-bold-700 text-danger"><?php echo singkat_angka($maintenanceCount); ?></h2>
					<p class="mb-0 line-ellipsis text-danger">Maintenance</p>
				</div>
			</div>
		</div>
	</a>
</div>
<?php
}
?>
