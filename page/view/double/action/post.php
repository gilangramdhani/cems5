<?php
ob_start();
session_start();
if (isset($_POST['action'])) {
	include '../../../config/db.php';
	$action = input($_POST['action']);
	if ($action == 'continue') {
		$user_id = $_SESSION['id'];
		$user_status = $_SESSION['status'];
		mysqli_query($con, "update user set user_status = '$user_status' where user_id = '$user_id'");
		/* sleep(10);
		mysqli_query($con, "update user set user_status = 'on' where user_id = '$user_id'");
		unset($_SESSION['status']);
		$_SESSION['status'] = 'on'; */
	}
	if ($action == 'exit') {
		unset($_SESSION['id']);
		unset($_SESSION['role']);
		unset($_SESSION['status']);
		session_destroy();
	}
}
?>