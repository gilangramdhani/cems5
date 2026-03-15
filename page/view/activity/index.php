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
								<div class="card-group row">
									<div class="card col-12 col-md-3">
										<div class="card-content">
											 <div class="card-body">
												<button id="add_btn" type="button" class="btn btn-primary btn-block">Add New</button>
												<br>
												<button id="activity_btn" class="btn btn-link" value="all"><i class="feather icon-activity"></i> All</button>
												<hr>
												<h5 class="mb-1">Filters</h5>
												<button id="activity_btn" class="btn btn-link" value="star"><i class="feather icon-star"></i> Starred</button>
												<br>
												<button id="activity_btn" class="btn btn-link" value="complete"><i class="feather icon-check"></i> Completed</button>
												<br>
												<button id="activity_btn" class="btn btn-link" value="trash"><i class="feather icon-trash"></i> Trashed</button>
												<hr>
												<h5 class="mb-1">Labels</h5>
												<button id="activity_btn" class="btn btn-link" value="troubleshoot"><i class="fa fa-circle text-primary"></i> Troubleshoot</button>
												<br>
												<button id="activity_btn" class="btn btn-link" value="service"><i class="fa fa-circle text-warning"></i> Service</button>
												<br>
												<button id="activity_btn" class="btn btn-link" value="maintenance"><i class="fa fa-circle text-danger"></i> Maintenance</button>
											 </div>
										</div>
									</div>
									<div class="card col-12 col-md-9">
										<div class="card-content">
											 <div class="card-body">
												<div id="my_form"></div>
												<div id="my_table">
													<fieldset class="form-group position-relative has-icon-left">
														<input id="search" type="text" class="form-control" autocomplete="off">
														<div class="form-control-position">
															<i class="feather icon-search"></i>
														</div>
													</fieldset>
													<div class="table-responsive">
														<table id="datatable" class="table nowrap">
															<thead style="display: none;">
																<tr>
																	<th>No.</th>
																	<th>Activity</th>
																	<th>Category</th>
																	<th>Description</th>
																	<th>Date</th>
																	<th>Action</th>
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
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
		<style>
		.dataTables_length, .dataTables_filter {
			display: none;
		}
		</style>