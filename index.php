<?php
ob_start();
session_start();
define('FILE_ACCESS', TRUE);
include 'page/config/db.php';
$client_id = client_id();
$secret_id = secret_id();
$verification_url = verification_url();
$key = md5($client_id.$secret_id);
$curl_header = array(
	"key:$key"
);
$curl_data = array();
$curl_data['page'] = 'client';
//$send = curl($verification_url, $curl_header, json_encode($curl_data));
//$response = json_decode($send, true);
$response['status'] = 'verified';
if ($response['status'] == 'unverified') {
	include 'page/view/suspend/index.php';
}
if ($response['status'] == 'verified') {
	if (!isset($_GET['p'])) {
		$p = 'dashboard';
		include header;
		include 'page/view/dashboard/index.php';
		include footer;
	}
	if (isset($_GET['p'])) {
		$p = input($_GET['p']);
		include header;
		$p_array = array(
			'dashboard',
			'cerobong',
			'profile',
			'report',
			'reportbydaterange',
			'reportbydate',
			'reportbymonth',
			'reportbyyear',
			'maintenance',
			'notif',
			'activity',
			'myprofile',
			'setting',
			'csv',
			'kirim',
			'logkirim',
			'user',
			'parameter',
			'logkirimdata'
		);
		if (!in_array($p, $p_array)) {
			include 'page/view/404/index.php';
		}
		if (in_array($p, $p_array)) {
			include 'page/view/'.$p.'/index.php';
		}
		include footer;
	}
}
mysqli_close($con);
?>
