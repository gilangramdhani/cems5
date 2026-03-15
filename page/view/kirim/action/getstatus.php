<?php
include('../../../../KLHKFunction.php');
include '../../../config/db.php';

$con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$klhk = new KLHKFunction();
$iskirim = $klhk->getconfig($con, 'isKirim');
echo json_encode(["isKirim" => $iskirim]);