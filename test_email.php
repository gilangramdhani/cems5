<?php
require_once 'vendor/autoload.php';
include 'page/config/db.php';
mysqli_query($con, "SET sql_mode = ''");
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
	$noxQuery = mysqli_query($con, "select parameter_threshold from parameter where parameter_code = 'NOx'");
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
	$o2Check = $o2Threshold - ($o2Threshold * 0.1);
	
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
		
		$countValid = mysqli_query($con, "select count(id) from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'valid' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i')");
		
		$countInvalid = mysqli_query($con, "select count(id) from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'invalid' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i')");
		
		$countCalibrate = mysqli_query($con, "select count(id) from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'calibrate' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i')");
		
		$countMaintenance = mysqli_query($con, "select count(id) from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'maintenance' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i')");
		
		$countThreshold = mysqli_query($con, "select d.id from notif n left join data d on n.notif_data = d.id where d.cerobong_id = '$cerobong' and d.status = 'valid' and date(d.waktu) = date('$q')");
		
		$query = mysqli_query($con, "select sum(case when parameter = 'NOx' THEN value END) NOx, sum(case when parameter = 'SO2' THEN value END) SO2, sum(case when parameter = 'PM' THEN value END) PM, sum(case when parameter = 'CO2' THEN value END) CO2, sum(case when parameter = 'Hg' THEN value END) Hg, sum(case when parameter = 'O2' THEN value END) O2, waktu, velocity, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'valid' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc");
		
		$query2 = mysqli_query($con, "select sum(case when parameter = 'NOx' THEN value END) NOx, sum(case when parameter = 'SO2' THEN value END) SO2, sum(case when parameter = 'PM' THEN value END) PM, sum(case when parameter = 'CO2' THEN value END) CO2, sum(case when parameter = 'Hg' THEN value END) Hg, sum(case when parameter = 'O2' THEN value END) O2, waktu, velocity, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'invalid' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc");
		
		$query3 = mysqli_query($con, "select sum(case when parameter = 'NOx' THEN value END) NOx, sum(case when parameter = 'SO2' THEN value END) SO2, sum(case when parameter = 'PM' THEN value END) PM, sum(case when parameter = 'CO2' THEN value END) CO2, sum(case when parameter = 'Hg' THEN value END) Hg, sum(case when parameter = 'O2' THEN value END) O2, waktu, velocity, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'calibrate' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc");
		
		$query4 = mysqli_query($con, "select sum(case when parameter = 'NOx' THEN value END) NOx, sum(case when parameter = 'SO2' THEN value END) SO2, sum(case when parameter = 'PM' THEN value END) PM, sum(case when parameter = 'CO2' THEN value END) CO2, sum(case when parameter = 'Hg' THEN value END) Hg, sum(case when parameter = 'O2' THEN value END) O2, waktu, velocity, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') and status = 'maintenance' group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc");
		
		$dir = '/var/www/html/email/';
		//array_map('unlink', glob($dir.'*'));
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'L'
		]);
		$html = '
			<div class="company">
				<h3>PT. ASAHIMAS CHEMICAL</h3>
				Banten, Indonesia<br>0254 601252
				
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
						<th>On Threshold</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.mysqli_num_rows($countValid).'</td>
						<td>'.mysqli_num_rows($countInvalid).'</td>
						<td>'.mysqli_num_rows($countCalibrate).'</td>
						<td>'.mysqli_num_rows($countMaintenance).'</td>
						<td>'.mysqli_num_rows($countThreshold).'</td>
					</tr>
				</tbody>
			</table>
		';
		//asahimas_report
		$html .= '<br><br>Custom Report<br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
						<th>Tanggal</th>
						<th>Parameter</th>
						<th>Konsentrasi rata-rata harian<br></th>
						<th>Baku mutu<br></th>
						<th>Satuan<br></th>
						<th>Laju alir rata-rata harian<br>(m/detik)</th>
						<th>Debit<br>(m3/detik)</th>
						<th>Waktu operasi sumber emisi<br>(jam)</th>
						<th>Jumah emisi<br>(ton)</th>
					</tr>
				</thead>
				<tbody>
		';
		$no = 0;
		$asahimasQuery = mysqli_query($con, "select * from asahimas_report where date(tanggal) = date('$q') and cerobong = '$cerobong'");
		while ($asahimasData = mysqli_fetch_array($asahimasQuery, MYSQLI_ASSOC)) {
			$satuanCheck = $asahimasData['parameter'];
			$satuanQuery = mysqli_query($con, "select * from parameter where parameter_code = '$satuanCheck'");
			$satuanData = mysqli_fetch_array($satuanQuery, MYSQLI_ASSOC);
			$no++;
			$html .= '
					<tr>
						<td>'.$no.'</td>
						<td>'.tanggal($asahimasData['tanggal']).'</td>
						<td>'.$asahimasData['parameter'].'</td>
						<td>'.$asahimasData['concentrate'].'</td>
						<td>'.$asahimasData['threshold'].'</td>
						<td>'.$satuanData['parameter_portion'].'</td>
						<td>'.$asahimasData['laju_alir'].'</td>
						<td>'.$asahimasData['debit'].'</td>
						<td>'.$asahimasData['waktu'].'</td>
						<td>'.$asahimasData['total'].'</td>
					</tr>
			';
		}
		$html .= '
				<tbody>
			</table>
		';
		//valid
		$html .= '<br><br><page_break>Data Valid<br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
		';
		$colorQuery = mysqli_query($con, "select * from parameter");
		while ($colorData = mysqli_fetch_array($colorQuery, MYSQLI_ASSOC)) {
			$html .= '<th>'.$colorData['parameter_code'].'</th>';
		}
		$html .= '
						<th>Waktu</th>
						<th>Velocity</th>
						<th>Status Gas</th>
						<th>Status Partikulat</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Tanggal Input</th>
					</tr>
				</thead>
				<tbody>
		';
		$no = 0;
		while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$nox = $data['NOx'];
			if ($nox >= $noxCheck) {
				$nox = '<span style="color: red;">'.$data['NOx'].'</span>';
			}
			$so2 = $data['SO2'];
			if ($so2 >= $so2Check) {
				$so2 = '<span style="color: red;">'.$data['SO2'].'</span>';
			}
			$pm = $data['PM'];
			if ($pm >= $pmCheck) {
				$pm = '<span style="color: red;">'.$data['PM'].'</span>';
			}
			$co2 = $data['CO2'];
			if ($co2 >= $co2Check) {
				$co2 = '<span style="color: red;">'.$data['CO2'].'</span>';
			}
			$hg = $data['Hg'];
			if ($hg >= $hgCheck) {
				$hg = '<span style="color: red;">'.$data['Hg'].'</span>';
			}
			$o2 = $data['O2'];
			if ($o2 >= $o2Check) {
				$o2 = '<span style="color: red;">'.$data['O2'].'</span>';
			}
			$no++;
			$html .= '
					<tr>
						<td>'.$no.'</td>
						<td>'.$nox.'</td>
						<td>'.$so2.'</td>
						<td>'.$pm.'</td>
						<td>'.$co2.'</td>
						<td>'.$hg.'</td>
						<td>'.$o2.'</td>
						<td>'.waktu($data['waktu']).'</td>
						<td>'.$data['velocity'].'</td>
						<td>'.$data['status_gas'].'</td>
						<td>'.$data['status_partikulat'].'</td>
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
		';
		$color2Query = mysqli_query($con, "select * from parameter");
		while ($color2Data = mysqli_fetch_array($color2Query, MYSQLI_ASSOC)) {
			$html .= '<th>'.$color2Data['parameter_code'].'</th>';
		}
		$html .= '
						<th>Waktu</th>
						<th>Velocity</th>
						<th>Status Gas</th>
						<th>Status Partikulat</th>
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
						<td>'.$data2['NOx'].'</td>
						<td>'.$data2['SO2'].'</td>
						<td>'.$data2['PM'].'</td>
						<td>'.$data2['CO2'].'</td>
						<td>'.$data2['Hg'].'</td>
						<td>'.$data2['O2'].'</td>
						<td>'.waktu($data2['waktu']).'</td>
						<td>'.$data2['velocity'].'</td>
						<td>'.$data2['status_gas'].'</td>
						<td>'.$data2['status_partikulat'].'</td>
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
		';
		$color3Query = mysqli_query($con, "select * from parameter");
		while ($color3Data = mysqli_fetch_array($color3Query, MYSQLI_ASSOC)) {
			$html .= '<th>'.$color3Data['parameter_code'].'</th>';
		}
		$html .= '
						<th>Waktu</th>
						<th>Velocity</th>
						<th>Status Gas</th>
						<th>Status Partikulat</th>
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
						<td>'.$data3['NOx'].'</td>
						<td>'.$data3['SO2'].'</td>
						<td>'.$data3['PM'].'</td>
						<td>'.$data3['CO2'].'</td>
						<td>'.$data3['Hg'].'</td>
						<td>'.$data3['O2'].'</td>
						<td>'.waktu($data3['waktu']).'</td>
						<td>'.$data3['velocity'].'</td>
						<td>'.$data3['status_gas'].'</td>
						<td>'.$data3['status_partikulat'].'</td>
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
		';
		$color4Query = mysqli_query($con, "select * from parameter");
		while ($color4Data = mysqli_fetch_array($color4Query, MYSQLI_ASSOC)) {
			$html .= '<th>'.$color4Data['parameter_code'].'</th>';
		}
		$html .= '
						<th>Waktu</th>
						<th>Velocity</th>
						<th>Status Gas</th>
						<th>Status Partikulat</th>
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
						<td>'.$data4['NOx'].'</td>
						<td>'.$data4['SO2'].'</td>
						<td>'.$data4['PM'].'</td>
						<td>'.$data4['CO2'].'</td>
						<td>'.$data4['Hg'].'</td>
						<td>'.$data4['O2'].'</td>
						<td>'.waktu($data4['waktu']).'</td>
						<td>'.$data4['velocity'].'</td>
						<td>'.$data4['status_gas'].'</td>
						<td>'.$data4['status_partikulat'].'</td>
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
$sendSmtpEmail['subject'] = 'Laporan data CEMS tanggal '.tanggal($tanggal);
//$userQuery = mysqli_query($con, "select * from user where user_notif = 1");
$userQuery = mysqli_query($con, "select * from user where user_email = 'titan8080@gmail.com'");
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
