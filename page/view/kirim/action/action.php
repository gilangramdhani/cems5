<?php
include('../../../../KLHKFunction.php');
include '../../../config/db.php';

$con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
$iskirim = $_POST['iskirim'];

$klhk = new KLHKFunction();
$klhk->saveconfig($con, 'isKirim', $iskirim);
echo json_encode(["status" => 'sukses']);