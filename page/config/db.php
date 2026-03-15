<?php
date_default_timezone_set("Asia/Jakarta");

// Use environment variables if they exist, otherwise use defaults
$dbhost = getenv('DB_HOST') ?: 'localhost';
$dbuser = getenv('DB_USER') ?: 'root';
$dbpass = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'cems';

$sql_details = array(
	'host' => $dbhost,
	'user' => $dbuser,
	'pass' => $dbpass,
	'db' => $dbname
);

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

include 'function.php';
?>
