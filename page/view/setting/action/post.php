<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	if (isset($_POST['company'])) {
		$company = input($_POST['company']);
		mysqli_query($con, "update config set config_value = '$company' where config_name = 'company'");
	}
	if (isset($_POST['province'])) {
		$province = input($_POST['province']);
		mysqli_query($con, "update config set config_value = '$province' where config_name = 'province'");
	}
	if (isset($_POST['phone'])) {
		$phone = input($_POST['phone']);
		mysqli_query($con, "update config set config_value = '$phone' where config_name = 'phone'");
	}
	if (isset($_POST['client_id'])) {
		$client_id = input($_POST['client_id']);
		mysqli_query($con, "update config set config_value = '$client_id' where config_name = 'client_id'");
	}
	if (isset($_POST['secret_id'])) {
		$secret_id = input($_POST['secret_id']);
		mysqli_query($con, "update config set config_value = '$secret_id' where config_name = 'secret_id'");
	}
	if (isset($_POST['address'])) {
		$address = input($_POST['address']);
		mysqli_query($con, "update config set config_value = '$address' where config_name = 'address'");
	}
	if (isset($_POST['telegram'])) {
		$telegram = input($_POST['telegram']);
		mysqli_query($con, "update config set config_value = '$telegram' where config_name = 'telegram'");
	}
	mysqli_query($con, "update parameter set parameter_status = ''");
	foreach($_POST['parameter_code'] as $code) {
		$parameter_code = input($code);
		mysqli_query($con, "update parameter set parameter_status = 'active' where parameter_code = '$parameter_code'");
	}
	echo 'Data has been updated';
}
?>