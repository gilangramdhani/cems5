<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	if (isset($_POST['action'])) {
		include '../../../config/db.php';
		$action = input($_POST['action']);
		if ($action == 'create') {
			$parameter_code = input($_POST['parameter_code']);
			$parameter_name = input($_POST['parameter_name']);
			$parameter_threshold = input($_POST['parameter_threshold']);
			$parameter_portion = input($_POST['parameter_portion']);
			$parameter_color = input($_POST['parameter_color']);
			$parameter_status = input($_POST['parameter_status']);
			if ($parameter_status == 'non-active') {
				$parameter_status = '';
			}
			mysqli_query($con, "insert ignore into parameter (parameter_code, parameter_name, parameter_threshold, parameter_portion, parameter_color, parameter_status) values ('$parameter_code', '$parameter_name', '$parameter_threshold', '$parameter_portion', '$parameter_color', '$parameter_status')");
			echo 'Data telah ditambah';
		}
		if ($action == 'update') {
			$id = input($_POST['id']);
			$parameter_code = input($_POST['parameter_code']);
			$parameter_name = input($_POST['parameter_name']);
			$parameter_threshold = input($_POST['parameter_threshold']);
			$parameter_portion = input($_POST['parameter_portion']);
			$parameter_color = input($_POST['parameter_color']);
			$parameter_status = input($_POST['parameter_status']);
			if ($parameter_status == 'non-active') {
				$parameter_status = '';
			}
			mysqli_query($con, "update parameter set parameter_code = '$parameter_code', parameter_name = '$parameter_name', parameter_threshold = '$parameter_threshold', parameter_portion = '$parameter_portion', parameter_color = '$parameter_color', parameter_status = '$parameter_status' where parameter_id = '$id'");
			echo 'Data telah diubah';
		}
		if ($action == 'delete') {
			$id = input($_POST['id']);
			mysqli_query($con, "delete from parameter where parameter_id = '$id'");
			echo 'Data telah dihapus';
		}
	}
}
?>