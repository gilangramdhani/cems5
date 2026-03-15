<?php
define ('header', 'page/common/header.php');
define ('sidebar', 'page/common/sidebar.php');
define ('footer', 'page/common/footer.php');

function client_id() {
	global $con;
	$clientQuery = mysqli_query($con, "select * from config where config_name = 'client_id'");
	$clientData = mysqli_fetch_array($clientQuery, MYSQLI_ASSOC);
	$client = $clientData['config_value'];
	return $client;
}

function secret_id() {
	global $con;
	$secretQuery = mysqli_query($con, "select * from config where config_name = 'secret_id'");
	$secretData = mysqli_fetch_array($secretQuery, MYSQLI_ASSOC);
	$secret = $secretData['config_value'];
	return $secret;
}

function verification_url() {
	global $con;
	$verificationQuery = mysqli_query($con, "select * from config where config_name = 'verification_url'");
	$verificationData = mysqli_fetch_array($verificationQuery, MYSQLI_ASSOC);
	$verification = $verificationData['config_value'];
	return $verification;
}

function company() {
	global $con;
	$companyQuery = mysqli_query($con, "select * from config where config_name = 'company'");
	$companyData = mysqli_fetch_array($companyQuery, MYSQLI_ASSOC);
	$company = $companyData['config_value'];
	return $company;
}

function phone() {
	global $con;
	$phoneQuery = mysqli_query($con, "select * from config where config_name = 'phone'");
	$phoneData = mysqli_fetch_array($phoneQuery, MYSQLI_ASSOC);
	$phone = $phoneData['config_value'];
	return $phone;
}

function province() {
	global $con;
	$provinceQuery = mysqli_query($con, "select * from config where config_name = 'province'");
	$provinceData = mysqli_fetch_array($provinceQuery, MYSQLI_ASSOC);
	$province = $provinceData['config_value'];
	return $province;
}

function province_name($q) {
	global $con;
	$province_nameQuery = mysqli_query($con, "select * from province where province_id = '$q'");
	$province_nameData = mysqli_fetch_array($province_nameQuery, MYSQLI_ASSOC);
	$province_name = $province_nameData['province_name'];
	return $province_name;
}

function country() {
	global $con;
	$countryQuery = mysqli_query($con, "select * from config where config_name = 'country'");
	$countryData = mysqli_fetch_array($countryQuery, MYSQLI_ASSOC);
	$country = $countryData['config_value'];
	return $country;
}

function lt() {
	global $con;
	$ltQuery = mysqli_query($con, "select * from config where config_name = 'lt'");
	$ltData = mysqli_fetch_array($ltQuery, MYSQLI_ASSOC);
	$lt = $ltData['config_value'];
	return $lt;
}

function lg() {
	global $con;
	$lgQuery = mysqli_query($con, "select * from config where config_name = 'lg'");
	$lgData = mysqli_fetch_array($lgQuery, MYSQLI_ASSOC);
	$lg = $lgData['config_value'];
	return $lg;
}

function logo() {
	global $con;
	$logoQuery = mysqli_query($con, "select * from config where config_name = 'logo'");
	$logoData = mysqli_fetch_array($logoQuery, MYSQLI_ASSOC);
	$logo = 'upload/'.$logoData['config_value'];
	return $logo;
}

function address() {
	global $con;
	$addressQuery = mysqli_query($con, "select * from config where config_name = 'address'");
	$addressData = mysqli_fetch_array($addressQuery, MYSQLI_ASSOC);
	$address = $addressData['config_value'];
	return $address;
}

function telegrambottoken() {
	global $con;
	$telegramQuery = mysqli_query($con, "select * from config where config_name = 'telegram'");
	$telegramData = mysqli_fetch_array($telegramQuery, MYSQLI_ASSOC);
	$telegram = $telegramData['config_value'];
	return $telegram;
}

function curl($url, $curl_header, $curl_data) {
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

function valid_email($str) {
	return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function bcrypt($password = '') {
	$hash = password_hash($password, PASSWORD_BCRYPT);
	return $hash;
}

function input($input) {
	$input = trim($input);
	$input = addslashes($input);
	$input = htmlspecialchars($input);
	global $con;
	$input = mysqli_real_escape_string($con, $input);
	return $input;
}

function waktu($date) {
	$waktu = date('d M Y H:i:s', strtotime($date));
	return $waktu;
}

function tanggal($date) {
	$tanggal = date('d M Y', strtotime($date));
	return $tanggal;
}

function jam($date) {
	$jam = date('H:i:s', strtotime($date));
	return $jam;
}

function singkat_angka($n, $presisi = 1) {
	if ($n < 900) {
		$format_angka = number_format($n, $presisi);
		$simbol = '';
	} else if ($n < 900000) {
		$format_angka = number_format($n / 1000, $presisi);
		$simbol = 'rb';
	} else if ($n < 900000000) {
		$format_angka = number_format($n / 1000000, $presisi);
		$simbol = 'jt';
	} else if ($n < 900000000000) {
		$format_angka = number_format($n / 1000000000, $presisi);
		$simbol = 'M';
	} else {
		$format_angka = number_format($n / 1000000000000, $presisi);
		$simbol = 'T';
	}
	if ($presisi > 0) {
		$pisah = '.' . str_repeat('0', $presisi);
		$format_angka = str_replace($pisah, '', $format_angka);
	}
	return $format_angka.$simbol;
}

function telegram($chat_id, $pesan, $token) {
	//$token = '2117533667:AAGyJCz86_DfrBSkLZUpFccJwU6UhmN0rLE';
	$API = 'https://api.telegram.org/bot'.$token.'/sendmessage?chat_id='.$chat_id.'&text='.$pesan;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_URL, $API);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>