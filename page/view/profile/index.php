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
					<section>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-content">
										<img class="card-img-top img-fluid" src="app-assets/images/profile/user-uploads/cover.jpg" alt="">
										<div class="card-body">
											<div class="row" style="position: relative; z-index: 100; background-color: #fff; margin-top: -100px; border-radius: 10px;">
												<div class="col-lg-2 text-center" style="margin: auto;">
													<br>
													<img src="<?php echo logo(); ?>" class="card-img-top img-fluid" alt="">
												</div>
												<div class="col-12 col-md-8">
													<br>
													<h4><?php echo company(); ?></h4>
													<small><strong>Address :</strong><br><?php echo nl2br(address()); ?><br><?php echo province_name(province()); ?>, <?php echo country(); ?></small>
													<br><br>
													<small><strong>Contact :</strong><br><?php echo phone(); ?></small>
												</div>
												<div class="col-12 col-md-2">
												    <br>
<?php
$fdate = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' -91 day'));
$tdate = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' -1 day'));
$validQuery = mysqli_query($con, "select count(id) as total from data where status = 'valid' and waktu between '$fdate' and '$tdate'");
$validData = mysqli_fetch_array($validQuery, MYSQLI_ASSOC);
$valid = $validData['total'];
$totalQuery = mysqli_query($con, "select count(id) as total from data where waktu between '$fdate' and '$tdate'");
$totalData = mysqli_fetch_array($totalQuery, MYSQLI_ASSOC);
$total = $totalData['total'];
if ($valid == 0) {
	$result = 0;
}
if ($valid <> 0) {
	$result = ($valid / $total) * 100;
}
if ($result >= 90 and $result <= 100) {
    $grade = 'A';
    $bg = 'bg-success';
}
if ($result >= 75 and $result < 90) {
    $grade = 'B';
    $bg = 'bg-warning';
}
if ($result < 75) {
    $grade = 'C';
    $bg = 'bg-danger';
}
?>
											        <div class="card text-center <?php echo $bg; ?>" data-toggle="tooltip" data-placement="left" data-html="true" title="<h5 class='text-white'>Keterangan</h5><ul><li>A = Jika data valid lebih dari 90% dari total data</li><li>B = Jika data valid lebih dari 75% dan kurang dari 90% dari total data</li><li>C = Jika data valid kurang dari 75% dari total data</li></ul>">
                                                		<div class="card-content">
                                                			<div class="card-body">
                                                			    <br>
                                                				<p class="text-bold-700 text-white" style="font-size: 50pt !important;"><?php echo $grade; ?></p>
                                                				<br>
                                                				<p class="mb-0 line-ellipsis text-bold-700 text-white">Performance</p>
                                                			</div>
                                                		</div>
                                                	</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<section>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Maps</h4>
									</div>
									<div class="card-content">
										<div class="card-body">
											<iframe src="https://maps.google.com/maps?q=<?php echo lt(); ?>,<?php echo lg(); ?>&hl=es;z=14&amp;output=embed" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
