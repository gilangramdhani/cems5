<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	if (isset($_POST['action'])) {
		include '../../../config/db.php';
		$action = input($_POST['action']);
		if ($action == 'upload') {
			$path = '../../../../upload/'.$_FILES['file']['name'];
			$source = $_FILES['file']['tmp_name'];
			move_uploaded_file($source, $path);
			echo 'CSV has been uploaded';
		}
	}
}
?>
