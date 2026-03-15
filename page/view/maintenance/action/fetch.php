<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		if ($action == 'update') {
			$id = $_POST['id'];
			$query = mysqli_query($con, "select * from cerobong where cerobong_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title"><?php echo $data['cerobong_name']; ?></h4>
		<div class="heading-elements">
			<ul class="list-inline mb-0">
				<li><button id="close_btn" type="button" class="btn btn-icon btn-flat-danger"><i class="feather icon-x"></i></button></li>
			</ul>
		</div>
	</div>
	<div class="card-content">
		<div class="card-body">
			<form id="form" method="post">
				<div class="row">
					<div class="col-12">
						<fieldset class="form-group">
							<label>Status</label>
							<select id="cerobong_status" class="form-control select2" name="cerobong_status" data-placeholder="Status" required="required">
								<option></option>
								<option value="active"<?php if ($data['cerobong_status'] == 'active') { echo ' selected'; } ?>>Active</option>
								<option value="calibrate"<?php if ($data['cerobong_status'] == 'calibrate') { echo ' selected'; } ?>>Calibrate</option>
								<option value="maintenance"<?php if ($data['cerobong_status'] == 'maintenance') { echo ' selected'; } ?>>Maintenance</option>
								<option value="rusak"<?php if ($data['cerobong_status'] == 'rusak') { echo ' selected'; } ?>>Rusak</option>
							</select>
						</fieldset>
					</div>
					<div class="col-12 col-md-6">
						<fieldset class="form-group">
							<label>From</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="feather icon-calendar"></i></span>
								</div>
								<input id="fromdate" type="text" class="form-control pickadate" name="fromdate" placeholder="Date" autocomplete="off" required="required">
								<input id="fromtime" type="text" class="form-control pickatime" name="fromtime" placeholder="Time" autocomplete="off" required="required">
							</div>
						</fieldset>
					</div>
					<div class="col-12 col-md-6">
						<fieldset class="form-group">
							<label>To</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="feather icon-calendar"></i></span>
								</div>
								<input id="todate" type="text" class="form-control pickadate" name="todate" placeholder="Date" autocomplete="off" required="required">
								<input id="totime" type="text" class="form-control pickatime" name="totime" placeholder="Time" autocomplete="off" required="required">
							</div>
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Remark</label>
							<textarea id="log_remark" type="text" class="form-control" name="log_remark"></textarea>
						</fieldset>
					</div>
					<div class="col-12">
						<input id="id" type="hidden" name="id" value="<?php echo $id; ?>">
						<input id="action" type="hidden" name="action" value="<?php echo $action; ?>">
						<button id="submit_btn" type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
		}
		if ($action == 'view') {
			$id = $_POST['id'];
			$query = mysqli_query($con, "select * from cerobong where cerobong_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Log : <?php echo $data['cerobong_name']; ?></h4>
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
							<th><center>No.</center></th>
							<th><center>Status</center></th>
							<th><center>Remark</center></th>
							<th><center>User</center></th>
							<th><center>Date</center></th>
						</tr>
					</thead>
					<tbody>
<?php
			$no = 0;
			$logQuery = mysqli_query($con, "select * from log where log_cerobong = '$id' order by log_id desc");
			while ($logData = mysqli_fetch_array($logQuery, MYSQLI_ASSOC)) {
				$no++;
?>
						<tr>
							<td class="text-center"><?php echo $no; ?></td>
							<td class="text-center"><?php echo $logData['log_status']; ?></td>
							<td class="text-center"><?php echo $logData['log_remark']; ?></td>
							<td class="text-center"><?php echo $logData['log_user']; ?></td>
							<td class="text-center"><?php echo waktu($logData['created_at']); ?></td>
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