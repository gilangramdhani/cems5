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
		<h4 class="card-title">Tambah Parameter</h4>
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
							<label>Kode</label>
							<input id="parameter_code" type="text" class="form-control" name="parameter_code" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Nama Parameter</label>
							<input id="parameter_name" type="text" class="form-control" name="parameter_name" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Baku Mutu</label>
							<input id="parameter_threshold" type="text" class="form-control" name="parameter_threshold" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Satuan</label>
							<input id="parameter_portion" type="text" class="form-control" name="parameter_portion" autocomplete="off" required="required">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Warna</label>
							<input id="parameter_color" type="color" class="form-control" name="parameter_color" autocomplete="off" required="required">
						</fieldset>
					</div>
					
					<div class="col-12">
						<fieldset class="form-group">
							<label>Status</label>
							<select id="parameter_status" class="form-control select2" name="parameter_status" data-placeholder="Status" required="required">
								<option value="active">Aktif</option>
								<option value="non-active">Tidak Aktif</option>
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
			$query = mysqli_query($con, "select * from parameter where parameter_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Ubah Parameter</h4>
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
							<label>Kode</label>
							<input id="parameter_code" type="text" class="form-control" name="parameter_code" autocomplete="off" required="required" value="<?php echo $data['parameter_code']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Nama Parameter</label>
							<input id="parameter_name" type="text" class="form-control" name="parameter_name" autocomplete="off" required="required" value="<?php echo $data['parameter_name']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Baku Mutu</label>
							<input id="parameter_threshold" type="text" class="form-control" name="parameter_threshold" autocomplete="off" required="required" value="<?php echo $data['parameter_threshold']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Satuan</label>
							<input id="parameter_portion" type="text" class="form-control" name="parameter_portion" autocomplete="off" required="required" value="<?php echo $data['parameter_portion']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Warna</label>
							<input id="parameter_color" type="color" class="form-control" name="parameter_color" autocomplete="off" required="required" value="<?php echo $data['parameter_color']; ?>">
						</fieldset>
					</div>
					<div class="col-12">
						<fieldset class="form-group">
							<label>Status</label>
							<select id="parameter_status" class="form-control select2" name="parameter_status" data-placeholder="Status" required="required">
								<option value="active"<?php if ($data['parameter_status'] == 'active') { echo ' selected'; } ?>>Aktif</option>
								<option value="non-active"<?php if ($data['parameter_status'] == '') { echo ' selected'; } ?>>Tidak Aktif</option>
							</select>
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
			$query = mysqli_query($con, "select * from parameter where parameter_id = '$id'");
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Hapus Parameter</h4>
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
						<p>Apakah Anda yakin akan menghapus <strong><?php echo $data['parameter_name']; ?></strong> dari database?
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
