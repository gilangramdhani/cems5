<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$user_full = input($_POST['user_full']);
	$user_pass = input(bcrypt($_POST['user_pass']));
	$user_id = $_SESSION['id'];
	mysqli_query($con, "update user set user_full = '$user_full', user_pass = '$user_pass' where user_id = '$user_id'");
	echo 'Data has been updated';
}
?>