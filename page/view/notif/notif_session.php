<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../config/db.php';
	$id = $_SESSION['id'];
	$query = mysqli_query($con, "select * from user where user_id = '$id'");
	$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$session_status = $_SESSION['status'];
	$data_status = $data['user_status'];
	if ($session_status <> $data_status) {
		echo 'autologout';
	}
}
?>