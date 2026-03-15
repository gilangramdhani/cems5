<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	if (isset($_POST['action'])) {
		include '../../../config/db.php';
		$action = input($_POST['action']);
		if ($action == 'upload') {
			array_map('unlink', glob('../../../../upload/*'));
			$logo = $_FILES['file']['name'];
			$path = '../../../../upload/'.$logo;
			$source = $_FILES['file']['tmp_name'];
			move_uploaded_file($source, $path);
			mysqli_query($con, "update config set config_value = '$logo' where config_name = 'logo'");
?>
<img src="<?php echo logo(); ?>" alt="" style="width: 100px; height: auto;">
<br><br>
<fieldset class="form-group">
	<input id="logo" type="file" class="form-control-file" name="logo" accept="image/*">
</fieldset>
<?php
		}
	}
}
?>
