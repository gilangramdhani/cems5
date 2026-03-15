<?php
date_default_timezone_set("Asia/Jakarta");
include('KLHKFunction.php');
include 'page/config/db.php';

$con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$klhk = new KLHKFunction();
$url = $klhk->getconfig($con, 'klhk_url');
$url_token = $klhk->getconfig($con, 'klhk_get_token');
$url_cerobong = $klhk->getconfig($con, 'klhk_get_cerobong');
$url_parameter = $klhk->getconfig($con, 'klhk_get_parameter');
$url_submit = $klhk->getconfig($con, 'klhk_submit');
$interval = $klhk->getconfig($con, 'interval');
$full_url_submit = $url.$url_submit;
$now = date('Y-m-d H:00:00');

$curl_header = array(
    "Content-Type:'application/json'"
);
$gettoken = $klhk->getdbtoken($con);
$token = $gettoken;
$curl_header = array(
    "Key:$token",
    "Content-Type:'application/json'"
);

$datetimes = $klhk->getnotkirimdata($con);
foreach($datetimes as $datetime){
    $kirim = $klhk->submit($con, $interval, $datetime);
	echo $kirim;
    $send = $klhk->postcurl($full_url_submit, $curl_header, $kirim);
    $responsekirim = json_decode($send['response'], true);
    if($send['statuscode'] == 200){
        $klhk->updatedatakirim($con, $datetime);
        $klhk->updatelogkirim($con, $datetime, $send['statuscode'], $responsekirim['message']);
        $klhk->savelog($con, $send['statuscode'], $responsekirim['message']);
    }else{
        $message = '';
        if($responsekirim['message'] == ''){
            $message = 'Tidak dapat terhubung';
        }else{
            $message = $responsekirim['message'];
        }
        $klhk->updatelogkirim($con, $datetime, $send['statuscode'], $message);
        $klhk->savelog($con, $send['statuscode'], $message);
    }
}
$con->close();