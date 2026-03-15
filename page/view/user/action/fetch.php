<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	if (isset($_POST['action'])) {
		$action = $_POST['action'];
		if ($action == 'create') {
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Tambah User</h4>
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
							<label>Email</label>
							<input id="user_email" type="email" class="form-control" name="user_email" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Password</label>
							<input id="user_pass" type="password" class="form-control" name="user_pass" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Nama Lengkap</label>
							<input id="user_full" type="text" class="form-control" name="user_full" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Hak Akses</label>
							<select id="user_role" class="form-control select2" name="user_role" data-placeholder="Hak Akses" required="required">
								<option></option>
								<option value="Admin">Admin</option>
								<option value="Engineer">Engineer</option>
								<option value="Operator">Operator</option>
							</select>
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Telegram (Chat ID)</label>
							<input id="user_telegram" type="text" class="form-control" name="user_telegram" autocomplete="off">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Terima Notif</label>
							<select id="user_notif" class="form-control select2" name="user_notif" data-placeholder="Terima Notif" required="required">
								<option></option>
								<option value=0>TIDAK</option>
								<option value=1>YA</option>
							</select>
						</fieldset>
					</div>
					<div class="col-12">
						<input id="action" type="hidden" name="action" value="<?php echo $action; ?>">
						<button id="submit_btn" type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
		}
		if ($action == 'update') {
			$id = $_POST['id'];
			$query = mysqli_query($con, "select * from user where user_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Ubah User</h4>
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
							<label>Email</label>
							<input id="user_email" type="email" class="form-control" name="user_email" autocomplete="off" required="required" value="<?php echo $data['user_email']; ?>" readonly>
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Nama Lengkap</label>
							<input id="user_full" type="text" class="form-control" name="user_full" autocomplete="off" required="required" value="<?php echo $data['user_full']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Hak Akses</label>
							<select id="user_role" class="form-control select2" name="user_role" data-placeholder="Hak Akses" required="required">
								<option></option>
								<option value="Admin"<?php if ($data['user_role'] == 'Admin') { echo ' selected'; } ?>>Admin</option>
								<option value="Engineer"<?php if ($data['user_role'] == 'Engineer') { echo ' selected'; } ?>>Engineer</option>
								<option value="Operator"<?php if ($data['user_role'] == 'Operator') { echo ' selected'; } ?>>Operator</option>
							</select>
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Terima Notif</label>
							<select id="user_notif" class="form-control select2" name="user_notif" data-placeholder="Terima Notif" required="required">
								<option></option>
								<option value="0"<?php if ($data['user_notif'] == 0) { echo ' selected'; } ?>>TIDAK</option>
								<option value="1"<?php if ($data['user_notif'] == 1) { echo ' selected'; } ?>>YA</option>
							</select>
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Telegram (Chat ID)</label>
							<input id="user_telegram" type="text" class="form-control" name="user_telegram" autocomplete="off" value="<?php echo $data['user_telegram']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<input id="id" type="hidden" name="id" value="<?php echo $id; ?>">
						<input id="action" type="hidden" name="action" value="<?php echo $action; ?>">
						<button id="submit_btn" type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
		}
		if ($action == 'delete') {
			$id = $_POST['id'];
			$query = mysqli_query($con, "select * from user where user_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Hapus User</h4>
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
						<p>Apakah Anda yakin akan menghapus <strong><?php echo $data['user_full']; ?></strong> dari database?
					</div>
					<div class="col-12">
						<input id="id" type="hidden" name="id" value="<?php echo $id; ?>">
						<input id="action" type="hidden" name="action" value="<?php echo $action; ?>">
						<button id="submit_btn" type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
		}
		if ($action == 'password') {
			$id = $_POST['id'];
			$query = mysqli_query($con, "select * from user where user_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Ubah Password</h4>
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
							<label>Email</label>
							<input id="user_email" type="email" class="form-control" name="user_email" autocomplete="off" required="required" value="<?php echo $data['user_email']; ?>" readonly>
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Password Baru</label>
							<input id="user_pass" type="password" class="form-control" name="user_pass" autocomplete="off" required="required">
						</fieldset>
					</div>
					
					<div class="col-12">
						<input id="id" type="hidden" name="id" value="<?php echo $id; ?>">
						<input id="action" type="hidden" name="action" value="<?php echo $action; ?>">
						<button id="submit_btn" type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
		}
	}
}
?>
