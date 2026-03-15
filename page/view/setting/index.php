		<div class="app-content content">
			<div class="content-overlay"></div>
			<div class="header-navbar-shadow"></div>
			<div class="content-wrapper">
				<div class="content-body">
					<section id="basic-datatable">
						<div class="row">
							<div class="col-12">
								<div id="my_form"></div>
								<div id="my_table">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title">Settings</h4>
										</div>
										<div class="card-content">
											<div class="card-body">
												<form id="form_upload" method="post" enctype="multipart/form-data">
													<div class="row">
														<div class="col-12 col-md-4">
															<strong>Logo</strong>
														</div>
														<div id="logonya" class="col-12 col-md-8">
															<img src="<?php echo logo(); ?>" alt="" style="width: 100px; height: auto;">
															<br><br>
															<fieldset class="form-group">
																<input id="logo" type="file" class="form-control-file" name="logo" accept="image/*">
															</fieldset>
														</div>
												</form>
												<form id="form" method="post">
													<div class="row">
														<div class="col-12">
															<hr>
														</div>
														<div class="col-12 col-md-4">
															<strong>Perusahaan</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input type="text" class="form-control" name="company" autocomplete="off" required="required" value="<?php echo company(); ?>">
															</fieldset>
														</div>
														<div class="col-12 col-md-4">
															<strong>Address</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<textarea class="form-control" name="address" required="required"><?php echo address(); ?></textarea>
															</fieldset>
														</div>
														<div class="col-12 col-md-4">
															<strong>Province</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<select class="form-control select2" name="province" data-placeholder="" required="required" style="width: 100%;">
																	<option></option>
<?php
$provinceQuery = mysqli_query($con, "select * from province");
while ($provinceData = mysqli_fetch_array($provinceQuery, MYSQLI_ASSOC)) {
?>
																	<option value="<?php echo $provinceData['province_id']; ?>"<?php if ($provinceData['province_id'] == province()) { echo ' selected'; } ?>><?php echo $provinceData['province_name']; ?></option>
<?php
}
?>
																</select>
															</fieldset>
														</div>
														<div class="col-12 col-md-4">
															<strong>No. Telp</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input type="text" class="form-control" name="phone" autocomplete="off" required="required" value="<?php echo phone(); ?>">
															</fieldset>
														</div>
														<div class="col-12">
															<hr>
														</div>
														<div class="col-12 col-md-4">
															<strong>Client ID</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input type="text" class="form-control" name="client_id" autocomplete="off" required="required" value="<?php echo client_id(); ?>">
															</fieldset>
														</div>
														<div class="col-12 col-md-4">
															<strong>Secret ID</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input type="text" class="form-control" name="secret_id" autocomplete="off" required="required" value="<?php echo secret_id(); ?>">
															</fieldset>
														</div>
														<div class="col-12 col-md-4">
															<strong>Telegram (Bot Token)</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input type="text" class="form-control" name="telegram" autocomplete="off" required="required" value="<?php echo telegrambottoken(); ?>">
															</fieldset>
														</div>
														<div class="col-12">
															<hr>
														</div>
														<div class="col-12 col-md-4">
															<strong>Parameter</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<select id="parameter_code" class="form-control select2" name="parameter_code[]" data-placeholder="" required="required" style="width: 100%;" multiple>
																	<option></option>
<?php
$parameterQuery = mysqli_query($con, "select * from parameter");
while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
?>
																	<option value="<?php echo $parameterData['parameter_code']; ?>"<?php if ($parameterData['parameter_status'] == 'active') { echo ' selected'; } ?>><?php echo $parameterData['parameter_name']; ?></option>
<?php
}
?>
																</select>
															</fieldset>
														</div>
														<div class="col-12">
															<hr>
														</div>
														<div class="col-12">
															<button id="submit_btn" type="submit" class="btn btn-primary">Simpan</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>