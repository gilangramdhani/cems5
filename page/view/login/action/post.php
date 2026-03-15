<?php
ob_start();
session_start();
if (isset($_POST['user_email']) and isset($_POST['user_pass'])) {
	include '../../../config/db.php';
	$user_email = input($_POST['user_email']);
	$user_pass = input($_POST['user_pass']);
	$query = mysqli_query($con, "select * from user where user_email = '$user_email'");
	if (mysqli_num_rows($query) <> 0) {
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$hash = $data['user_pass'];
		if (password_verify($user_pass, $hash)) {
			$user_status = $data['user_status'];
			if ($user_status == '') {
				$_SESSION['id'] = $data['user_id'];
				$_SESSION['role'] = $data['user_role'];
				$_SESSION['status'] = session_id();
				$user_id = $_SESSION['id'];
				$status = $_SESSION['status'];
				//mysqli_query($con, "update user set user_status = '$status' where user_id = '$user_id'");
				echo 'ok';
			}
			if ($user_status <> '') {
				$_SESSION['id'] = $data['user_id'];
				$_SESSION['role'] = $data['user_role'];
				$_SESSION['status'] = session_id();
				echo 'double';
			}
		}
	}
	mysqli_close($con);
}
?>