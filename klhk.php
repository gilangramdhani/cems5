<?php
date_default_timezone_set("Asia/Jakarta");


include 'page/config/db.php';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

function postcurl($url, $curl_header, $curl_data) {
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $curl_header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($ch); 
	curl_close($ch);      
	return $output;
}

$url = 'https://ditppu.menlhk.go.id/sispekv2/';
//$url = 'http://mwsolusi.co.id/sispek/';
$curl_header = array(
	"Content-Type:'application/json'"
);

//get token
$loginurl = 'api/v2/token';
$fullurl = $url.$loginurl;
//echo $fullurl;
$client_id = client_id();
$secret_id = secret_id();
$key = md5($client_id.$secret_id);
$logindata = array();
$logindata['app_id'] = $client_id;
$logindata['app_pwd_hash'] = $key;
$send = postcurl($fullurl, $curl_header, json_encode($logindata));
$responsetoken = json_decode($send, true);
$token = 'Bearer '.$responsetoken['token'];

//get cerobong
$cerobongurl = 'api/v2/cerobong';
$fullurl = $url.$cerobongurl;

$curl_header = array(
	"Key:$token"
);
$sendcerobong = postcurl($fullurl, $curl_header, json_encode($logindata));
$responsecerobong = json_decode($sendcerobong, true);
$cerobong = $responsecerobong['cerobong'];
$getonecerobong = $cerobong[0]['kode_cerobong'];
//echo $sendcerobong;
//echo $getonecerobong;

//getparameter
$parameterurl = 'api/v2/parameter';
$fullurl = $url.$parameterurl;

$curl_header = array(
	"Key:$token"
);
$cerobongdata = array();
$cerobongdata['cerobong_kode'] = $getonecerobong;
$sendparameter = postcurl($fullurl, $curl_header, json_encode($cerobongdata));
$responseparameter = json_decode($sendparameter, true);
$parameter = $responseparameter['parameter'];
//echo $sendparameter;

//submit value
$sendurl = 'api/v2/submit';
$fullurl = $url.$sendurl;

$curl_header = array(
	"Key:$token"
);

$now = date('Y-m-d H:i:s');
$yesterday = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($now))); 
//$yesterday = '2021-10-07 14:00:00';
//$now = '2021-10-07 15:00:00';
$datasubmit = array();
$getcerobongsql = mysqli_query($con, "SELECT * FROM cerobong WHERE cerobong_status = 'active'");
if (mysqli_num_rows($getcerobongsql) <> 0) {
	while ($getcerobong = mysqli_fetch_array($getcerobongsql, MYSQLI_ASSOC)) {
		$dataparameter = array();
		$alldata = array();
		$cerobongid = $getcerobong['cerobong_id'];
		$dataparameter['kode_cerobong'] = $getcerobong['cerobong_code'];
		$dataparameter['interval'] = 5;
		$gettimesql = mysqli_query($con, "SELECT data.waktu FROM data JOIN parameter ON parameter.parameter_code = data.parameter WHERE waktu between '$yesterday' AND '$now' AND status_sispek = '' GROUP BY data.waktu");
		while ($gettime = mysqli_fetch_array($gettimesql, MYSQLI_ASSOC)) {
			//echo $gettime['waktu'];
			$dataarray = array();
			$waktu = $gettime['waktu'];
			$dataarray['waktu'] = $waktu;
			$check2Query = mysqli_query($con, "SELECT data.*, parameter.parameter_name FROM data JOIN parameter ON parameter.parameter_code = data.parameter WHERE waktu = '$waktu' AND cerobong_id = '$cerobongid'");
			while ($checkData = mysqli_fetch_array($check2Query, MYSQLI_ASSOC)) {
				//echo $checkData['value'].' ';
				$valueparameter = $checkData['parameter_name'];
				
				$lajualir = $checkData['laju_alir'];
				if($checkData['parameter'] == 'O2'){
					$dataarray['oksigen'] = $checkData['value'];
				}else{
					$dataarray[$valueparameter] = $checkData['value'];
				}
			}
			$dataarray['laju_alir'] = $lajualir;
			$alldata[] = $dataarray;
		}
		$dataparameter['parameter'] = $alldata;
		$datasubmit[] = $dataparameter;
	}
}
echo json_encode(['data' => $datasubmit]);
$send = postcurl($fullurl, $curl_header, json_encode(['data' => $datasubmit]));
echo $send;
$response = json_decode($send, true);
//echo $response['message'];
if($response['message'] == 'Sukses'){
	mysqli_query($con, "update data set status_sispek = 'Terkirim' where waktu between '$yesterday' and '$now'");
}
mysqli_close($con);

