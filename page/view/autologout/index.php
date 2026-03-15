<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../config/db.php';
	$user_id = $_SESSION['id'];
	unset($_SESSION['id']);
	unset($_SESSION['role']);
	unset($_SESSION['status']);
	if (session_destroy()) {
		header('Location: ./');
	}
}
?>