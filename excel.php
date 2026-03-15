<style> .str{ mso-number-format:\@; } </style>
<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include 'page/config/db.php';
	mysqli_query($con, "SET sql_mode = ''");
	header('Content-type: application/vnd-ms-excel');
	header('Content-Disposition: attachment; filename=data.xls');
	if (isset($_GET['p'])) {
		$p = input($_GET['p']);
		if ($p == 'reportbydate') {
			$q = date('Y-m-d', strtotime(input($_GET['q'])));
			$cerobong = input($_GET['cerobong']);
			$cat = input($_GET['cat']);
			$prm = implode("','",json_decode(stripslashes($_GET['prm'])));
			$cerobongQuery = mysqli_query($con, "select * from cerobong where cerobong_id = '$cerobong'");
			$cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC);
			$cerobong_name = $cerobongData['cerobong_name'];
			
?>
	<h2>Laporan Data pada tanggal <?php echo tanggal($q); ?></h2>
	<br>
	<h3>
	Hasil Pemantauan <?php echo $cerobong_name; ?>
	<br>
	Parameter : <?php echo "['".$prm."']"; ?></h3>
<?php
			if ($cat == 'all') {
				$query = mysqli_query($con, "select * from asahimas_report a left join parameter p on a.parameter = p.parameter_code where a.parameter in ('".$prm."') and a.cerobong = '$cerobong' and date(a.tanggal) = date('$q') order by a.tanggal desc");
?>
				<br>
<?php
				$query2 = mysqli_query($con, "select * from data where parameter in ('".$prm."') and cerobong_id = '$cerobong' and date(waktu) = date('$q') order by waktu desc");
?>
				<table border="1">
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Laju Alir</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Load</th>
						<th>Tanggal Input</th>
					</tr>
<?php
				$no = 0;
				while ($data2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
					if ($data2['status_sispek'] == 'Terkirim') {
						$status_sispek = 'Online';
					} else {
						$status_sispek = 'Offline';
					}
					$no++;
					echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$data2['parameter'].'</td>
							<td class="str">'.$data2['value'].'</td>
							<td>'.waktu($data2['waktu']).'</td>
							<td class="str">'.$data2['laju_alir'].'</td>
							<td>'.$data2['status'].'</td>
							<td>'.$data2['fuel'].'</td>
							<td>'.$data2['load'].'</td>
							<td>'.waktu($data2['modified_at']).'</td>
						</tr>
					';
				}
?>
				</table>
<?php
			}
		}
		if ($p == 'reportbydaterange') {
			$fromdate = date('Y-m-d', strtotime(input($_GET['fromdate'])));
			$todate = date('Y-m-d', strtotime(input($_GET['todate'])));
			$cerobong = input($_GET['cerobong']);
			$cat = input($_GET['cat']);
			$prm = implode("','",json_decode(stripslashes($_GET['prm'])));
			$cerobongQuery = mysqli_query($con, "select * from cerobong where cerobong_id = '$cerobong'");
			$cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC);
			$cerobong_name = $cerobongData['cerobong_name'];
			
?>
	<h2>Laporan Data pada tanggal <?php echo tanggal($fromdate).' sampai tanggal '.tanggal($todate); ?></h2>
	<br>
	<h3>
	Hasil Pemantauan <?php echo $cerobong_name; ?>
	<br>
	Parameter : <?php echo "['".$prm."']"; ?></h3>
<?php
			if ($cat == 'all') {
				$query = mysqli_query($con, "select * from asahimas_report a left join parameter p on a.parameter = p.parameter_code where a.parameter in ('".$prm."') and a.cerobong = '$cerobong' and date(a.tanggal) between date('$fromdate') and date('$todate') order by a.tanggal desc");
?>
				<br>
<?php
				$query2 = mysqli_query($con, "select * from data where parameter in ('".$prm."') and cerobong_id = '$cerobong' and date(waktu) between date('$fromdate') and date('$todate') order by waktu desc");
?>
				<table border="1">
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Laju Alir</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Load</th>
						<th>Tanggal Input</th>
					</tr>
<?php
				$no = 0;
				while ($data2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
					if ($data2['status_sispek'] == 'Terkirim') {
						$status_sispek = 'Online';
					} else {
						$status_sispek = 'Offline';
					}
					$no++;
					echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$data2['parameter'].'</td>
							<td class="str">'.$data2['value'].'</td>
							<td>'.waktu($data2['waktu']).'</td>
							<td class="str">'.$data2['laju_alir'].'</td>
							<td>'.$data2['status'].'</td>
							<td>'.$data2['fuel'].'</td>
							<td>'.$data2['load'].'</td>
							<td>'.waktu($data2['modified_at']).'</td>
						</tr>
					';
				}
?>
				</table>
<?php
			}
		}
		if ($p == 'reportbymonth') {
			$bulan = input($_GET['bulan']);
			$tahun = input($_GET['tahun']);
			$q = date('Y-m-d', strtotime(input($bulan.'/01/'.$tahun)));
			$cerobong = input($_GET['cerobong']);
			$cat = input($_GET['cat']);
			$prm = implode("','",json_decode(stripslashes($_GET['prm'])));
			$cerobongQuery = mysqli_query($con, "select * from cerobong where cerobong_id = '$cerobong'");
			$cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC);
			$cerobong_name = $cerobongData['cerobong_name'];
			
?>
	<h2>Laporan Data pada bulan <?php echo $bulan.' dan tahun '.$tahun; ?></h2>
	<br>
	<h3>
	Hasil Pemantauan <?php echo $cerobong_name; ?>
	<br>
	Parameter : <?php echo "['".$prm."']"; ?></h3>
<?php
			if ($cat == 'all') {
				$query = mysqli_query($con, "select * from asahimas_report a left join parameter p on a.parameter = p.parameter_code where a.parameter in ('".$prm."') and a.cerobong = '$cerobong' and month(a.tanggal) = month('$q') and year(a.tanggal) = year('$q') order by a.tanggal desc");
?>
				<br>
<?php
				$query2 = mysqli_query($con, "select * from data where parameter in ('".$prm."') and cerobong_id = '$cerobong' and month(waktu) = month('$q') and year(waktu) = year('$q') order by waktu desc");
?>
				<table border="1">
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Laju Alir</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Load</th>
						<th>Tanggal Input</th>
					</tr>
<?php
				$no = 0;
				while ($data2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
					if ($data2['status_sispek'] == 'Terkirim') {
						$status_sispek = 'Online';
					} else {
						$status_sispek = 'Offline';
					}
					$no++;
					echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$data2['parameter'].'</td>
							<td class="str">'.$data2['value'].'</td>
							<td>'.waktu($data2['waktu']).'</td>
							<td class="str">'.$data2['laju_alir'].'</td>
							<td>'.$data2['status'].'</td>
							<td>'.$data2['fuel'].'</td>
							<td>'.$data2['load'].'</td>
							<td>'.waktu($data2['modified_at']).'</td>
						</tr>
					';
				}
?>
				</table>
<?php
			}
		}
		if ($p == 'reportbyyear') {
			$tahun = input($_GET['tahun']);
			$q = date('Y-m-d', strtotime(input('01/01/'.$tahun)));
			$cerobong = input($_GET['cerobong']);
			$cat = input($_GET['cat']);
			$prm = implode("','",json_decode(stripslashes($_GET['prm'])));
			$cerobongQuery = mysqli_query($con, "select * from cerobong where cerobong_id = '$cerobong'");
			$cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC);
			$cerobong_name = $cerobongData['cerobong_name'];
			
?>
	<h2>Laporan Data pada tahun <?php echo $tahun; ?></h2>
	<br>
	<h3>
	Hasil Pemantauan <?php echo $cerobong_name; ?>
	<br>
	Parameter : <?php echo "['".$prm."']"; ?></h3>
<?php
			if ($cat == 'all') {
				$query = mysqli_query($con, "select * from asahimas_report a left join parameter p on a.parameter = p.parameter_code where a.parameter in ('".$prm."') and a.cerobong = '$cerobong' and year(a.tanggal) = year('$q') order by a.tanggal desc");
?>
				<br>
<?php
				 $query2 = mysqli_query($con, "select * from data where parameter in ('".$prm."') and cerobong_id = '$cerobong' and year(waktu) = year('$q') order by waktu desc");
?>
				<table border="1">
					<tr>
						<th>No.</th>
						<th>Parameter</th>
						<th>Value</th>
						<th>Waktu</th>
						<th>Laju Alir</th>
						<th>Status</th>
						<th>Fuel</th>
						<th>Load</th>
						<th>Tanggal Input</th>
					</tr>
<?php
				$no = 0;
				while ($data2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
					if ($data2['status_sispek'] == 'Terkirim') {
						$status_sispek = 'Online';
					} else {
						$status_sispek = 'Offline';
					}
					$no++;
					echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$data2['parameter'].'</td>
							<td class="str">'.$data2['value'].'</td>
							<td>'.waktu($data2['waktu']).'</td>
							<td class="str">'.$data2['laju_alir'].'</td>
							<td>'.$data2['status'].'</td>
							<td>'.$data2['fuel'].'</td>
							<td>'.$data2['load'].'</td>
							<td>'.waktu($data2['modified_at']).'</td>
						</tr>
					';
				}
?>
				</table>
<?php
			}
		}
	}
}
?>
