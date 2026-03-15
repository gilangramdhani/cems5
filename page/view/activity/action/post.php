<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	if (isset($_POST['action'])) {
		include '../../../config/db.php';
		$action = input($_POST['action']);
		if ($action == 'create') {
			$activity_title = input($_POST['activity_title']);
			$activity_cat = input($_POST['activity_cat']);
			$activity_desc = input($_POST['activity_desc']);
			$activity_status = '';
			$activity_from = input($_POST['activity_from']);
			$activity_to = input($_POST['activity_to']);
			mysqli_query($con, "insert ignore into activity (activity_title, activity_cat, activity_desc, activity_status, activity_from, activity_to, modified_at) values ('$activity_title', '$activity_cat', '$activity_desc', '$activity_status', '$activity_from', '$activity_to', NOW())");
			echo 'Data has been created';
		}
		if ($action == 'star') {
			$id = input($_POST['id']);
			mysqli_query($con, "update activity set activity_status = 'star', modified_at = NOW() where activity_id = '$id'");
			echo 'Data has been rated';
		}
		if ($action == 'unstar') {
			$id = input($_POST['id']);
			mysqli_query($con, "update activity set activity_status = '', modified_at = NOW() where activity_id = '$id'");
			echo 'Data has been unrated';
		}
		if ($action == 'trash') {
			$id = input($_POST['id']);
			mysqli_query($con, "update activity set activity_status = 'trash', modified_at = NOW() where activity_id = '$id'");
			echo 'Data has been deleted';
		}
		if ($action == 'complete') {
			$id = input($_POST['id']);
			mysqli_query($con, "update activity set activity_status = 'complete', modified_at = NOW() where activity_id = '$id'");
			echo 'Data has been completed';
		}
	}
}
?>