<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	if (isset($_POST['action'])) {
		include '../../../config/db.php';
		$action = input($_POST['action']);
		$id = input($_POST['id']);
		
		if ($action == 'update') {			
			$userCheck = $_SESSION['id'];
			$userQuery = mysqli_query($con, "select * from user where user_id = '$userCheck'");
			$userData = mysqli_fetch_array($userQuery, MYSQLI_ASSOC);
			$user = $userData['user_full'];
			$cerobong_status = input($_POST['cerobong_status']);
			if ($cerobong_status <> 'active') {
				$fromdate = date('Y-m-d', strtotime(input($_POST['fromdate'])));
				$fromtime = date('H:i:s', strtotime(input($_POST['fromtime'])));
				$cerobong_from = $fromdate.' '.$fromtime;
				$todate = date('Y-m-d', strtotime(input($_POST['todate'])));
				$totime = date('H:i:s', strtotime(input($_POST['totime'])));
				$cerobong_to = $todate.' '.$totime;
				$cerobong_schedule = input($_POST['cerobong_status']);
				mysqli_query($con, "update cerobong set cerobong_schedule = '$cerobong_schedule', cerobong_from = '$cerobong_from', cerobong_to = '$cerobong_to', cerobong_user = '$user' where cerobong_id = '$id'");
			}
			if ($cerobong_status == 'active') {
				mysqli_query($con, "update cerobong set cerobong_status = '$cerobong_status', cerobong_schedule = '', cerobong_from = null, cerobong_to = null, cerobong_user = '$user' where cerobong_id = '$id'");
			}
			$log_remark = input($_POST['log_remark']);
			//log
			mysqli_query($con, "insert ignore into log (log_cerobong, log_user, log_status, log_remark) values ('$id', '$user', '$cerobong_status', '$log_remark')");
			echo 'Data has been updated';
		}
	}
}
?>