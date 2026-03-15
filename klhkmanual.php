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
$datetime = $_GET['datetime'];
$now = date('Y-m-d H:00:00');

$curl_header = array(
    "Content-Type:'application/json'"
);

$auth = $klhk->get_token($con, $curl_header, $url, $url_token);
$response = json_decode($auth['response'], true);
if($auth['statuscode'] == 201){
    $token = 'Bearer '.$response['token'];
    $klhk->savetoken($con, $token);
    $gettoken = $klhk->getdbtoken($con);
    $token = $gettoken;
    $curl_header = array(
        "Key:$token",
        "Content-Type:'application/json'"
    );
    $kirim = $klhk->submit($con, $interval, $datetime);
    // /echo json_encode(["data"=>$kirim]);
    $send = $klhk->postcurl($full_url_submit, $curl_header, $kirim);
    if($send['statuscode'] == 200){
        $klhk->updatedatakirim($con, $datetime);
    }
    $responsekirim = json_decode($send['response'], true);
    $klhk->savelog($con, $auth['statuscode'], $responsekirim['message']);
    $countlog = $klhk->countdblogkirim($con, $datetime);
    if($countlog == 1){
        $klhk->updatelogkirim($con, $datetime, $send['statuscode'], $responsekirim['message']);
    }else{
        $klhk->savelogkirim($con, $datetime, $send['statuscode'], $responsekirim['message']);
    }
    echo json_encode($responsekirim);
}else{
    $klhk->savelog($con, $auth['statuscode'], $response['message']);
    echo 'Authentikasi gagal';
}
$con->close();