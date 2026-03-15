<?php

use GuzzleHttp\Psr7\Message;

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

$isKirim = $klhk->getconfig($con, 'isKirim');
if($isKirim == 1){
    $auth = $klhk->get_token($con, $curl_header, $url, $url_token);
    $response = json_decode($auth['response'], true);
    if($auth['statuscode'] == 201){
        $klhk->savelog($con, $auth['statuscode'], 'token');
        $token = 'Bearer '.$response['token'];
        $curl_header = array(
            "Key:$token",
            "Content-Type:'application/json'"
        );
        $klhk->savetoken($con, $token);
        $kirim = $klhk->submit($con, $interval, $now);
        echo $kirim;
        $send = $klhk->postcurl($full_url_submit, $curl_header, $kirim);
        $responsekirim = json_decode($send['response'], true);
        if($send['statuscode'] == 200){
            $klhk->updatedatakirim($con, $now);
        }
        $klhk->savelog($con, $send['statuscode'], $responsekirim['message']);
        $klhk->savelogkirim($con, $now, $send['statuscode'], $responsekirim['message']);
    }else{
        $message = '';
        if($responsekirim['message'] == ''){
            $message = 'Tidak dapat terhubung';
        }else{
            $message = $responsekirim['message'];
        }
        $klhk->savelog($con, $auth['statuscode'], $message);
        $klhk->savelogkirim($con, $now, $auth['statuscode'], $message);
        echo 'Authentikasi gagal';
    }
}
$con->close();
