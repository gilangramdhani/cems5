<?php
require_once 'vendor/autoload.php';
include 'page/config/db.php';
include('KLHKFunction.php');
mysqli_query($con, "SET sql_mode = ''");
$klhk = new KLHKFunction();
$company = $klhk->getconfig($con, 'company');
$address = $klhk->getconfig($con, 'address');
$phone = $klhk->getconfig($con, 'phone');
/* $client_id = client_id();
$secret_id = secret_id();
$verification_url = verification_url();
$key = md5($client_id.$secret_id);
$curl_header = array(
	"key:$key"
);
$curl_data = array(
	'page' => 'client'
);
$send = curl($verification_url, $curl_header, json_encode($curl_data));
$response = json_decode($send, true); */
$response['status'] = 'verified';
if ($response['status'] == 'verified') {
	//mencari threshold
	/* $noxQuery = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'NOx'");
	$noxData = mysqli_fetch_array($noxQuery, MYSQLI_ASSOC);
	$noxThreshold = $noxData['parameter_threshold'];
	$noxCheck = $noxThreshold - ($noxThreshold * 0.1);
	$so2Query = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'SO2'");
	$so2Data = mysqli_fetch_array($so2Query, MYSQLI_ASSOC);
	$so2Threshold = $so2Data['parameter_threshold'];
	$so2Check = $so2Threshold - ($so2Threshold * 0.1);
	$pmQuery = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'PM'");
	$pmData = mysqli_fetch_array($pmQuery, MYSQLI_ASSOC);
	$pmThreshold = $pmData['parameter_threshold'];
	$pmCheck = $pmThreshold - ($pmThreshold * 0.1);
	$co2Query = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'CO2'");
	$co2Data = mysqli_fetch_array($co2Query, MYSQLI_ASSOC);
	$co2Threshold = $co2Data['parameter_threshold'];
	$co2Check = $co2Threshold - ($co2Threshold * 0.1);
	$hgQuery = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'Hg'");
	$hgData = mysqli_fetch_array($hgQuery, MYSQLI_ASSOC);
	$hgThreshold = $hgData['parameter_threshold'];
	$hgCheck = $hgThreshold - ($hgThreshold * 0.1);
	$o2Query = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'O2'");
	$o2Data = mysqli_fetch_array($o2Query, MYSQLI_ASSOC);
	$o2Threshold = $o2Data['parameter_threshold'];
	$o2Check = $o2Threshold - ($o2Threshold * 0.1); */
	
	$q = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' -1 day'));
	$fdate = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' -91 day'));
	$tdate = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').' -1 day'));
	$cerobongQuery = mysqli_query($con, "select * from cerobong");
	while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
		$cerobong = $cerobongData['cerobong_id'];
		$cerobong_name = $cerobongData['cerobong_name'];
		
		$validQuery = mysqli_query($con, "select count(id) as count from data where status = 'valid' and cerobong_id = '$cerobong' and waktu between '$fdate' and '$tdate'");
		//$valid = mysqli_num_rows($validQuery);
		$validData = mysqli_fetch_array($validQuery, MYSQLI_ASSOC);
		$valid = $validData['count'];
		$totalQuery = mysqli_query($con, "select count(id) as count from data where cerobong_id = '$cerobong' and waktu between '$fdate' and '$tdate'");
		//$total = mysqli_num_rows($totalQuery);
		$totalData = mysqli_fetch_array($totalQuery, MYSQLI_ASSOC);
		$total = $totalData['count'];
		if ($valid == 0) {
			$result = 0;
		}
		if ($valid <> 0) {
			$result = ($valid / $total) * 100;
		}
		if ($result >= 90 and $result <= 100) {
			$grade = 'A';
			$bg = 'bg-success';
		}
		if ($result >= 75 and $result < 90) {
			$grade = 'B';
			$bg = 'bg-warning';
		}
		if ($result < 75) {
			$grade = 'C';
			$bg = 'bg-danger';
		}
		
		$countValid = mysqli_query($con, "select id from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'valid'");
		
		$countInvalid = mysqli_query($con, "select id from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'invalid'");
		
		$countCalibrate = mysqli_query($con, "select id from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'calibrate'");
		
		$countMaintenance = mysqli_query($con, "select id from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'maintenance'");
		
		$countDown = mysqli_query($con, "select id from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'down'");
		
		$countThreshold = mysqli_query($con, "select d.id from notif n left join data d on n.notif_data = d.id where d.cerobong_id = '$cerobong' and d.status = 'valid' and date(d.waktu) = date('$q')");
		
		$query = mysqli_query($con, "select * from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'valid' order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc limit 10");
		
		$query2 = mysqli_query($con, "select * from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'invalid' order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc limit 10");
		
		$query3 = mysqli_query($con, "select * from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'calibrate' order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc limit 10");
		
		$query4 = mysqli_query($con, "select * from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'maintenance' order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc limit 10");
		
		$dir = '/var/www/html/email/';
		//array_map('unlink', glob($dir.'*'));
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'L'
		]);
		$html = '
			<div class="company">
				<h3>'.$company.'</h3>
				'.$address.'<br>'.$phone.'
				
			</div>
			<div class="performance '.$bg.'">
				<h1>'.$grade.'</h1>
				Performance
			</div>
		';
		/* $html = '
			<div class="company">
				<h3>'.$response['company'].'</h3>
				'.$response['province'].', '.$response['country'].'<br>'.$response['phone'].'
				
			</div>
			<div class="performance '.$bg.'">
				<h1>'.$grade.'</h1>
				Performance
			</div>
		'; */
		$html .= '<hr><p class="title"><strong>Laporan</strong><br><u>Data '.$cerobong_name.' pada tanggal '.tanggal($q).'</u></p>';
		//$html .= '<img src="chart1.png"><br><br><page_break>';
		//$html .= '<p align="center"><u>Detail data '.$cerobong_name.' pada tanggal '.tanggal($q).'</u></p>';
		//count
		$html .= '
			<br><br>Total Data<br>
			<table class="demo">
				<thead>
					<tr>
						<th>Valid</th>
						<th>Invalid</th>
						<th>Calibrate</th>
						<th>Maintenance</th>
						<th>System Down</th>
						<th>Exceed Threshold</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.mysqli_num_rows($countValid).'</td>
						<td>'.mysqli_num_rows($countInvalid).'</td>
						<td>'.mysqli_num_rows($countCalibrate).'</td>
						<td>'.mysqli_num_rows($countMaintenance).'</td>
						<td>'.mysqli_num_rows($countDown).'</td>
						<td>'.mysqli_num_rows($countThreshold).'</td>
					</tr>
				</tbody>
			</table>
		';
		//valid
		$html .= '<br><br><page_break>Data Valid<br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Flow</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Tanggal Input</th>
					</tr>
				</thead>
				<tbody>
		';
		$no = 0;
		while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$no++;
			$html .= '
					<tr>
						<td>'.$no.'</td>
						<td>'.$data['parameter'].'</td>
						<td>'.$data['value'].'</td>
						<td>'.waktu($data['waktu']).'</td>
						<td>'.$data['laju_alir'].'</td>
						<td>'.$data['status'].'</td>
						<td>'.$data['fuel'].'</td>
						<td>'.waktu($data['modified_at']).'</td>
					</tr>
			';
		}
		$html .= '
				<tbody>
			</table>
		';
		//invalid
		$html .= '<br><br>Data Invalid<br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Laju Alir</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Tanggal Input</th>
					</tr>
				</thead>
				<tbody>
		';
		$no = 0;
		while ($data2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
			$no++;
			$html .= '
					<tr>
						<td>'.$no.'</td>
						<td>'.$data2['parameter'].'</td>
						<td>'.$data2['value'].'</td>
						<td>'.waktu($data2['waktu']).'</td>
						<td>'.$data2['laju_alir'].'</td>
						<td>'.$data2['status'].'</td>
						<td>'.$data2['fuel'].'</td>
						<td>'.waktu($data2['modified_at']).'</td>
					</tr>
			';
		}
		$html .= '
				<tbody>
			</table>
		';
		//calibrate
		$html .= '<br><br>Data Calibrate<br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Laju Alir</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Tanggal Input</th>
					</tr>
				</thead>
				<tbody>
		';
		$no = 0;
		while ($data3 = mysqli_fetch_array($query3, MYSQLI_ASSOC)) {
			$no++;
			$html .= '
					<tr>
						<td>'.$no.'</td>
						<td>'.$data3['parameter'].'</td>
						<td>'.$data3['value'].'</td>
						<td>'.waktu($data3['waktu']).'</td>
						<td>'.$data3['laju_alir'].'</td>
						<td>'.$data3['status'].'</td>
						<td>'.$data3['fuel'].'</td>
						<td>'.waktu($data3['modified_at']).'</td>
					</tr>
			';
		}
		$html .= '
				<tbody>
			</table>
		';
		//maintenance
		$html .= '<br><br>Data Maintenance<br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Laju Alir</th>
						<th>Velocity</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Tanggal Input</th>
					</tr>
				</thead>
				<tbody>
		';
		$no = 0;
		while ($data4 = mysqli_fetch_array($query4, MYSQLI_ASSOC)) {
			$no++;
			$html .= '
					<tr>
						<td>'.$no.'</td>
						<td>'.$data4['parameter'].'</td>
						<td>'.$data4['value'].'</td>
						<td>'.waktu($data4['waktu']).'</td>
						<td>'.$data4['laju_alir'].'</td>
						<td>'.$data4['status'].'</td>
						<td>'.$data4['fuel'].'</td>
						<td>'.waktu($data4['modified_at']).'</td>
					</tr>
			';
		}
		$html .= '
				<tbody>
			</table>
		';
		
		$stylesheet = file_get_contents('/var/www/html/style.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
		$filename = $cerobong.'-'.date('Y-m-d',strtotime(date('Y-m-d').' -1 day'));
		$mpdf->Output($dir.$filename.'.pdf');
	}
}
//sendinblue
$dir = '/var/www/html/email/';
$tanggal = date('Y-m-d',strtotime(date('Y-m-d').' -1 day'));
$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', 'YOUR_API_KEY_HERE');
$apiInstance = new SendinBlue\Client\Api\SMTPApi(new GuzzleHttp\Client(), $config);
$sendSmtpEmail = new SendinBlue\Client\Model\SendSmtpEmail();
$sendSmtpEmail['sender'] = array('name'=> 'Admin MWS', 'email'=>'admin@mwsolusi.com');
$sendSmtpEmail['subject'] = 'Laporan data CEMS '.$company.' tanggal '.tanggal($tanggal);
$userQuery = mysqli_query($con, "select * from user where user_notif = 1");
$userArray = array();
while ($userData = mysqli_fetch_array($userQuery, MYSQLI_ASSOC)) {
	$arr = [
		'name' => $userData['user_full'],
		'email' => $userData['user_email']
	];
	array_push($userArray, $arr);
}
$sendSmtpEmail['to'] = $userArray;
$sendSmtpEmail['htmlContent'] = 'Laporan Data CEMS pada tanggal '.tanggal($tanggal);
$attachment_list = array();
$map = opendir($dir);
while ($filename = readdir($map)) {
	if ($filename == '.' || $filename == '..')
	continue;
	$file = $dir.$filename;
	$content = chunk_split(base64_encode(file_get_contents($file)));
	$filearr = [
		'name' => $filename,
		'content' => $content
	];
	array_push($attachment_list, $filearr);
}
closedir($map);
$sendSmtpEmail['attachment'] = $attachment_list;
try {
	$result = $apiInstance->sendTransacEmail($sendSmtpEmail);
	print_r($result);
} catch (Exception $e) {
	echo 'Exception when calling SMTPApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
}
array_map('unlink', glob($dir.'*'));
?>

