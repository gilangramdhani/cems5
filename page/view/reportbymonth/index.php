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
										<div class="card-body">
											<form id="form" method="post">
												<div class="row">
													<div class="col-12 col-md-5">
														<fieldset class="form-group">
															<label></label>
															<select id="bulan" class="form-control select2" name="bulan" data-placeholder="Bulan" required="required">
																<option></option>
																<option value="01">Januari</option>
																<option value="02">Februari</option>
																<option value="03">Maret</option>
																<option value="04">April</option>
																<option value="05">Mei</option>
																<option value="06">Juni</option>
																<option value="07">Juli</option>
																<option value="08">Agustus</option>
																<option value="09">September</option>
																<option value="10">Oktober</option>
																<option value="11">November</option>
																<option value="12">Desember</option>
															</select>
														</fieldset>
														<fieldset class="form-group">
															<label></label>
															<input id="cat" type="hidden" name="cat" value="all">
															<select id="prm" class="form-control select2" name="prm[]" data-placeholder="Kategori" required="required" multiple>
																<option></option>
<?php
$parameterQuery = mysqli_query($con, "select * from parameter");
while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
?>
																<option value="<?php echo $parameterData['parameter_code']; ?>"><?php echo $parameterData['parameter_name']; ?></option>
<?php
}
?>
															</select>
														</fieldset>
													</div>
													<div class="col-12 col-md-5">
														<fieldset class="form-group">
															<label></label>
															<select id="tahun" class="form-control select2" name="tahun" data-placeholder="Tahun" required="required">
																<option></option>
<?php
$tahun = date('Y');
for ($y = date('Y') - 5; $y <= date('Y'); $y++) {
    echo '<option value="'.$y.'">'.$y.'</option>';
}
?>
																
															</select>
														</fieldset>
														<fieldset class="form-group">
															<label></label>
															<select id="cerobong" class="form-control select2" name="cerobong" data-placeholder="Cerobong" required="required">
																<option></option>
<?php
$cerobongQuery = mysqli_query($con, "select * from cerobong");
while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
?>
																<option value="<?php echo $cerobongData['cerobong_id']; ?>"><?php echo $cerobongData['cerobong_name']; ?></option>
<?php
}
?>
															</select>
														</fieldset>
													</div>
													<div class="col-12 col-md-2">
														<fieldset class="form-group">
															<label></label>
															<button id="submit_btn" type="submit" class="btn btn-primary btn-block"><i class="feather icon-search"></i></button>
														</fieldset>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<div id="my_data"></div>
				</div>
			</div>
		</div>
