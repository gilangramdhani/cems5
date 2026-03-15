<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	if (isset($_POST['action'])) {
		include '../../../config/db.php';
		$action = input($_POST['action']);
		if ($action == 'create') {
			$user_full = input($_POST['user_full']);
			$user_email = input($_POST['user_email']);
			$user_pass = input(bcrypt($_POST['user_pass']));
			$user_role = input($_POST['user_role']);
			$user_notif = input($_POST['user_notif']);
			$user_telegram = input($_POST['user_telegram']);
			mysqli_query($con, "insert ignore into user (user_full, user_email, user_pass, user_notif, user_role, user_telegram) values ('$user_full', '$user_email', '$user_pass', '$user_notif', '$user_role', '$user_telegram')");
			echo 'Data telah ditambah';
		}
		if ($action == 'update') {
			$id = input($_POST['id']);
			$user_full = input($_POST['user_full']);
			$user_role = input($_POST['user_role']);
			$user_notif = input($_POST['user_notif']);
			$user_telegram = input($_POST['user_telegram']);
			mysqli_query($con, "update user set user_full = '$user_full', user_role = '$user_role', user_notif = '$user_notif', user_telegram = '$user_telegram' where user_id = '$id'");
			echo 'Data telah diubah';
		}
		if ($action == 'delete') {
			$id = input($_POST['id']);
			mysqli_query($con, "delete from user where user_id = '$id'");
			echo 'Data telah dihapus';
		}
		if ($action == 'password') {
			$id = input($_POST['id']);
			$user_pass = input(bcrypt($_POST['user_pass']));
			mysqli_query($con, "update user set user_pass = '$user_pass' where user_id = '$id'");
			echo 'Password telah diubah';
		}
	}
}
?>