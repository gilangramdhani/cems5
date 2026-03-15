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
					<section id="dashboard-analytics">
						<div id="mini_alert" class="row">
							<div class="col-12">
								<p class="text-center bg-white">Loading...</p>
							</div>
						</div>
						<div id="mini_info" class="row">
							<div class="col-12">
								<p class="text-center bg-white">Loading...</p>
							</div>
						</div>
						
						<div class="row">
<?php
$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
?>
							<div class="col-12 col-md-4">
								<div class="card">
									<div class="card-header d-flex flex-column align-items-start pb-0">
										<h4 class="text-bold-700 mt-1 mb-25"><?php echo $parameterData['parameter_name']; ?></h4>
										<p class="mb-0"><?php echo $parameterData['parameter_portion']; ?></p>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div id="<?php echo $parameterData['parameter_code']; ?>"></div>
									</div>
								</div>
							</div>
<?php
}
?>
							<div class="col-12 col-md-4">
								<div class="card">
									<div class="card-header d-flex flex-column align-items-start pb-0">
										<h4 class="text-bold-700 mt-1 mb-25">Flow</h4>
										<p class="mb-0">m3/s</p>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="card-content">
										<div id="flow"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
<?php
$cerobongQuery = mysqli_query($con, "select * from cerobong");
while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
?>
							<div id="cerobong<?php echo $cerobongData['cerobong_id']; ?>_chart" class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title"><?php echo $cerobongData['cerobong_name']; ?></h4>
									</div>
									<div class="card-content">
										<div class="card-body">
											<div id="all<?php echo $cerobongData['cerobong_id']; ?>"></div>
										</div>
									</div>
								</div>
							</div>
<?php
}
?>
						</div>
						
					</section>
				</div>
			</div>
		</div>
