<?php
ob_start();
session_start();
require_once '../../../../vendor/autoload.php';
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$client_id = client_id();
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
	$response = json_decode($send, true);
	if ($response['status'] == 'verified') {
		$action = $_POST['action'];
		if ($action == 'download') {
			$q = date('Y-m-d', strtotime(input($_GET['q'])));
			$cerobong = input($_GET['cerobong']);
			$cat = input($_GET['cat']);
			$uri = input($_POST['uri']);
			
			$validQuery = mysqli_query($con, "select * from data where status = 'valid'");
			$valid = mysqli_num_rows($validQuery);
			$totalQuery = mysqli_query($con, "select * from data");
			$total = mysqli_num_rows($totalQuery);
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
			if ($cat <> 'all') {
				$query = mysqli_query($con, "select * from data where parameter = '$cat' and cerobong_id = '$cerobong' and date(waktu) = date('$q') order by waktu desc");
			}
			if ($cat == 'all') {
				$query = mysqli_query($con, "select sum(case when parameter = 'NOx' THEN value END) NOx, sum(case when parameter = 'SO2' THEN value END) SO2, sum(case when parameter = 'PM' THEN value END) PM, sum(case when parameter = 'CO2' THEN value END) CO2, sum(case when parameter = 'Hg' THEN value END) Hg, sum(case when parameter = 'O2' THEN value END) O2, waktu, laju_alir, status_gas, status_partikulat, status, fuel, `load`, cerobong_id, modified_at from data where cerobong_id = '$cerobong' and date(waktu) = date('$q') group by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') order by DATE_FORMAT(waktu, '%Y-%m-%d %H:%i') desc;");
			}
			
			$dir = '../../../../download/';
			array_map('unlink', glob($dir.'*'));
			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8',
				'format' => 'A4',
				'orientation' => 'L'
			]);
			$html = '
				<div class="company">
					<h3>'.$response['company'].'</h3>
					'.$response['province'].', '.$response['country'].'<br>'.$response['phone'].'
					
				</div>
				<div class="performance '.$bg.'">
					<h1>'.$grade.'</h1>
					Performance
				</div>
			';
			$html .= '<hr><p class="title"><strong>Laporan</strong><br><u>Grafik rata - rata data pada tanggal '.tanggal($q).'</u></p>';
			$html .= '<img src="'.$uri.'"><br><br><page_break>';
			$html .= '<p align="center"><u>Detail data pada tanggal '.tanggal($q).'</u></p>';
			if ($cat <> 'all') {
				$html .= '
					<table class="demo">
						<thead>
							<tr>
								<th>No.</th>
								<th>Parameter</th>
								<th>Value</th>
								<th>Waktu</th>
								<th>Laju Alir</th>
								<th>Status Gas</th>
								<th>Status Partikulat</th>
								<th>Status</th>
								<th>Fuel</th>
								<th>Load</th>
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
								<td>'.$data['status_gas'].'</td>
								<td>'.$data['status_partikulat'].'</td>
								<td>'.$data['status'].'</td>
								<td>'.$data['fuel'].'</td>
								<td>'.$data['load'].'</td>
								<td>'.waktu($data['modified_at']).'</td>
							</tr>
					';
				}
				$html .= '
						<tbody>
					</table>
				';
			}
			if ($cat == 'all') {
				$html .= '
					<table class="demo">
						<thead>
							<tr>
								<th>No.</th>
				';
				$colorQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
				while ($colorData = mysqli_fetch_array($colorQuery, MYSQLI_ASSOC)) {
					$html .= '<th>'.$colorData['parameter_code'].'</th>';
				}
				$html .= '
								<th>Waktu</th>
								<th>Laju Alir</th>
								<th>Status Gas</th>
								<th>Status Partikulat</th>
								<th>Status</th>
								<th>Fuel</th>
								<th>Load</th>
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
								<td>'.$data['NOx'].'</td>
								<td>'.$data['SO2'].'</td>
								<td>'.$data['PM'].'</td>
								<td>'.$data['CO2'].'</td>
								<td>'.$data['Hg'].'</td>
								<td>'.$data['O2'].'</td>
								<td>'.waktu($data['waktu']).'</td>
								<td>'.$data['laju_alir'].'</td>
								<td>'.$data['status_gas'].'</td>
								<td>'.$data['status_partikulat'].'</td>
								<td>'.$data['status'].'</td>
								<td>'.$data['fuel'].'</td>
								<td>'.$data['load'].'</td>
								<td>'.waktu($data['modified_at']).'</td>
							</tr>
					';
				}
				$html .= '
						<tbody>
					</table>
				';
			}
			$html .= '
				<p><strong>Total keseluruhan CO2 :</strong></p>
			';
			$stylesheet = file_get_contents('style.css');
			$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
			$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
			$filename = 'data';
			$mpdf->Output($dir.$filename.'.pdf');
			if (file_exists($dir.$filename.'.pdf')) {
				echo 'download/'.$filename.'.pdf';
			}
		}
	}
}
?>
