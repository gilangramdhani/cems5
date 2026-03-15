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
											<h4 class="card-title">My Profile</h4>
										</div>
										<div class="card-content">
											<div class="card-body">
												<form id="form" method="post">
													<div class="row">
														<div class="col-12 col-md-4">
															<strong>Nama Lengkap</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input id="user_full" type="text" class="form-control" name="user_full" autocomplete="off" required="required" value="<?php echo $userData['user_full']; ?>">
															</fieldset>
														</div>
														<div class="col-12 col-md-4">
															<strong>Password</strong>
														</div>
														<div class="col-12 col-md-8">
															<fieldset class="form-group">
																<input id="user_pass" type="password" class="form-control" name="user_pass" autocomplete="off" required="required" placeholder="********">
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