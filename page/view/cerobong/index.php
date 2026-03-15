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
	$query = mysqli_query($con, "select * from cerobong where cerobong_id = '$q'");
	$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
					<section id="apexchart">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title"><?php echo $data['cerobong_name']; ?></h4>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div class="card-body">
											<div id="all"></div>
										</div>
									</div>
								</div>
							</div>
<?php
	$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
	while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
?>
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title"><?php echo $parameterData['parameter_name']; ?><br><small><?php echo $parameterData['parameter_portion']; ?></small></h4>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div class="card-body">
											<div id="<?php echo $parameterData['parameter_code']; ?>"></div>
										</div>
									</div>
								</div>
							</div>
<?php
	}
?>
						</div>
					</section>
					<!--
					<section id="basic-datatable">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Data <?php echo $data['cerobong_name']; ?></h4>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div class="card-body card-dashboard">
											<div class="table-responsive">
												<table id="datatable" class="table nowrap">
													<thead>
														<tr>
															<th class="text-center">No.</th>
															<th class="text-center">Parameter</th>
															<th class="text-center">Value</th>
															<th class="text-center">Waktu</th>
															<th class="text-center">Flow(m3/s)</th>
															<th class="text-center">Status</th>
															<th class="text-center">Fuel</th>
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
					-->
					<section id="basic-datatable-status">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Status Pengiriman Data <?php echo $data['cerobong_name']; ?></h4>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div class="card-body card-dashboard">
											<div class="table-responsive">
												<table id="datatablestatus" class="table nowrap">
													<thead>
														<tr>
															<th class="text-center">Waktu</th>
															<th class="text-center">Jam</th>
															<th class="text-center">Status Pengiriman</th>
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

