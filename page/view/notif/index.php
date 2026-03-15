<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
		<div class="app-content content">
			<div class="content-overlay"></div>
			<div class="header-navbar-shadow"></div>
			<div class="content-wrapper">
				<div class="content-body">
<?php
if (isset($_GET['q'])) {
	$q = input($_GET['q']);
	$q_array = array('all_data', 'valid', 'calibrate', 'invalid', 'maintenance', 'threshold');
	if ($q <> 'all_notif') {
?>
					<section id="basic-datatable">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
<?php
		if ($q == 'all_data') {
?>
										<h4 class="card-title">All Data</h4>
<?php
		}
		if ($q == 'valid') {
?>
										<h4 class="card-title">All Valid Data</h4>
<?php
		}
		if ($q == 'calibrate') {
?>
										<h4 class="card-title">All Calibrate Data</h4>
<?php
		}
		if ($q == 'invalid') {
?>
										<h4 class="card-title">All Invalid Data</h4>
<?php
		}
		if ($q == 'maintenance') {
?>
										<h4 class="card-title">All Maintenance Data</h4>
<?php
		}
		if ($q == 'threshold') {
?>
										<h4 class="card-title">All Threshold Data</h4>
<?php
		}
		if (!in_array($q, $q_array)) {
?>
										<h4 class="card-title">&nbsp;</h4>
<?php
		}
?>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div class="card-body card-dashboard">
											<input id="q" type="hidden" name="q" value="<?php echo $q; ?>">
											<div class="table-responsive">
												<table id="datatable" class="table nowrap">
													<thead>
														<tr>
															<th class="text-center">No.</th>
															<th class="text-center">Cerobong</th>
															<th class="text-center">Parameter</th>
															<th class="text-center">Value</th>
															<th class="text-center">Waktu</th>
															<th class="text-center">Velocity</th>
															<th class="text-center">Status Gas</th>
															<th class="text-center">Status Partikulat</th>
															<th class="text-center">Status</th>
															<th class="text-center">Fuel</th>
															<th class="text-center">Load</th>
															<th class="text-center">Status Sispek</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
<?php
	}
	if ($q == 'all_notif') {
		$dataQuery = mysqli_query($con, "select * from notif n left join data d on n.notif_data = d.id left join parameter p on d.parameter = p.parameter_code order by d.waktu desc limit 100");
		if (mysqli_num_rows($dataQuery) <> 0) {
?>
					<p id="loading" class="alert alert-primary">Loading...</p>
					<section id="custom-listgroup">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">All Notifications</h4>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><button id="download_btn" type="button" class="btn btn-icon btn-flat-success" action="download"><i class="feather icon-download"></i></button></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div class="card-body">
											<div class="row">
												<div class="col-12 col-md-4">
													<img src="app-assets/images/pages/404.png" class="img-fluid" alt="">
													<br><br>
													<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
												</div>
												<div class="col-12 col-md-8">
													<div class="list-group">
<?php
			while ($dataData = mysqli_fetch_array($dataQuery, MYSQLI_ASSOC)) {
?>
														<a href="notif/<?php echo $dataData['notif_data']; ?>" class="list-group-item list-group-item-action">
															<div class="d-flex w-100 justify-content-between">
<?php
				if ($dataData['status'] == 'invalid') {
?>
																<h5 class="text-secondary">
																	New invalid data
																</h5>
<?php
				}
				if ($dataData['status'] == 'calibrate') {
?>
																<h5 class="text-warning">
																	New calibrate data
																</h5>
<?php
				}
				if ($dataData['status'] == 'maintenance') {
		?>
																<h5 class="text-danger">
																	New maintenance data
																</h5>
<?php
				}
				$status_array = array('invalid', 'calibrate', 'maintenance');
				if (!in_array($dataData['status'], $status_array)) {
					$valCheck = $dataData['parameter_threshold'];
					$value = $dataData['value'];
					if ($value < $valCheck) {
						echo '<h5 class="text-primary">The data is approaching the threshold</h5>';
					}
					if ($value == $valCheck) {
						echo '<h5 class="text-primary">Data are at threshold</h5>';
					}
					if ($value > $valCheck) {
						echo '<h5 class="text-primary">Data exceeds threshold</h5>';
					}
				}
?>
																<small class="text-muted text-right"><?php echo tanggal($dataData['waktu']); ?><br><?php echo jam($dataData['waktu']); ?></small>
															</div>
														</a>
<?php
			}
?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>						
						</div>
					</section>
<?php
		}
	}
}
if (!isset($_GET['q'])) {
?>
					<section>
						<div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
							<div class="card-content">
								<div class="card-body text-center">
									<img src="app-assets/images/pages/404.png" class="img-fluid align-self-center" alt="">
									<h1 class="font-large-2 my-1">404 - Page Not Found!</h1>
								</div>
							</div>
						</div>
					</section>
<?php
}
?>
				</div>
			</div>
		</div>