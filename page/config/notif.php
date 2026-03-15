<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include 'db.php';
	$action = input($_POST['action']);
	if ($action == 'read') {
		mysqli_query($con, "update notif set notif_status = '$action'");
	}
}
