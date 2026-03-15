<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		if ($action == 'create') {
			$session_id = $_SESSION['id'];
?>
<div class="row">
	<div class="col-12">
		<form id="form" method="post">
			<div class="row">
				<div class="col-12">
					<fieldset class="form-group">
						<label>Ditujukan Kepada</label>
						<input id="activity_from" type="hidden" name="activity_from" value="<?php echo $session_id; ?>">
						<select id="activity_to" class="form-control select2" name="activity_to" data-placeholder="" required="required">
							<option></option>
<?php
			$userQuery = mysqli_query($con, "select * from user where user_id <> '$session_id'");
			while ($userData = mysqli_fetch_array($userQuery, MYSQLI_ASSOC)) {
?>
							<option value="<?php echo $userData['user_id']; ?>"><?php echo $userData['user_full']; ?></option>
<?php
			}
?>
						</select>
					</fieldset>
					<fieldset class="form-group">
						<label>Judul</label>
						<input id="activity_title" type="text" class="form-control" name="activity_title" autocomplete="off" required="required">
					</fieldset>
					<fieldset class="form-group">
						<label>Kategori</label>
						<select id="activity_cat" class="form-control select2" name="activity_cat" data-placeholder="" required="required">
							<option></option>
							<option value="troubleshoot">Troubleshoot</option>
							<option value="service">Service</option>
							<option value="maintenance">Maintenance</option>
						</select>
					</fieldset>
					<fieldset class="form-group">
						<label>Deskripsi</label>
						<textarea id="activity_desc" class="form-control" name="activity_desc" required="required"></textarea>
					</fieldset>
					<input id="action" type="hidden" name="action" value="<?php echo $action; ?>">
					<button id="submit_btn" type="submit" class="btn btn-primary">Send</button>
				</div>
		</form>
	</div>
</div>
<?php
		}
		if ($action == 'view') {
			$id = $_POST['id'];
			$query = mysqli_query($con, "select * from activity a left join user u on a.activity_from = u.user_id where a.activity_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if ($data['activity_cat'] == 'troubleshoot') {
				$color = 'primary';
			}
			if ($data['activity_cat'] == 'service') {
				$color = 'warning';
			}
			if ($data['activity_cat'] == 'maintenance') {
				$color = 'danger';
			}
			$toCheck = $data['activity_to'];
			$toQuery = mysqli_query($con, "select * from user where user_id = '$toCheck'");
			$toData = mysqli_fetch_array($toQuery, MYSQLI_ASSOC);
?>
<div class="row">
	<div class="col-12">
		<div class="row">
			<div class="col-12 col-md-6 text-center">
				<h6>Dari<br><small><?php echo $data['user_full']; ?></small><h6>
			</div>
			<div class="col-12 col-md-6 text-center">
				<h6>Ditujukan kepada<br><small><?php echo $toData['user_full']; ?></small><h6>
			</div>
		</div>
		<hr>
		<strong><?php echo $data['activity_title']; ?></strong>
		<span class="badge badge-pill badge-light-<?php echo $color; ?>"><span class="bullet bullet-<?php echo $color; ?> bullet-xs"></span> <?php echo $data['activity_cat']; ?></span><small><br><?php echo waktu($data['created_at']); ?></small>
		<br><br>
		<?php echo nl2br($data['activity_desc']); ?>
		<br><br>
<?php
		$status_array = array('', 'star');
		if (in_array($data['activity_status'], $status_array)) {
?>
		<button id="complete_btn" type="button" class="btn btn-success" value="<?php echo $id; ?>"><i class="feather icon-check"></i> Complete</button>
<?php
		}
?>
	</div>
</div>
<?php
		}
	}
}
?>