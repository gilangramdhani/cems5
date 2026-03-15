<?php
ob_start();
session_start();
require_once '../../../../vendor/autoload.php';
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$action = $_POST['action'];
	if ($action == 'download') {
		
		$query = mysqli_query($con, "select * from notif n left join data d on n.notif_data = d.id left join cerobong c on d.cerobong_id = c.cerobong_id left join parameter p on d.parameter = p.parameter_code order by d.waktu desc limit 100");
		
		$dir = '../../../../download/';
		array_map('unlink', glob($dir.'*'));
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'orientation' => 'P'
		]);
		$html = '<p class="title"><strong>Notifications</strong></p>';
		$html .= '<br><br>';
		$html .= '
			<table class="demo">
				<thead>
					<tr>
						<th>No.</th>
						<th>Cerobong</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Velocity</th>
						<th>Status Gas</th>
						<th>Status Patikulat</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Load</th>
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
						<td>'.$data['cerobong_name'].'</td>
						<td>'.$data['parameter_name'].'</td>
						<td>'.$data['value'].'</td>
						<td>'.waktu($data['waktu']).'</td>
						<td>'.$data['velocity'].'</td>
						<td>'.$data['status_gas'].'</td>
						<td>'.$data['status_partikulat'].'</td>
						<td>'.$data['status'].'</td>
						<td>'.$data['fuel'].'</td>
						<td>'.$data['load'].'</td>
					</tr>
			';
		}
		$html .= '
				<tbody>
			</table>
		';
		$stylesheet = file_get_contents('style.css');
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
		$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
		$filename = 'notif';
		$mpdf->Output($dir.$filename.'.pdf');
		if (file_exists($dir.$filename.'.pdf')) {
			echo 'download/'.$filename.'.pdf';
		}
	}
}
?>
