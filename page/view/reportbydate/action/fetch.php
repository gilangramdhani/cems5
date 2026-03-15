<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	include '../../../config/db.php';
	$q = date('Y-m-d', strtotime(input($_POST['q'])));
	$cerobong = input($_POST['cerobong']);
	$cat = input($_POST['cat']);
	$prm = '["'.implode('","',$_POST['prm']).'"]';
?>
<p id="loading" class="alert alert-primary">Loading...</p>
<section id="apexchart">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Grafik rata - rata data pada tanggal <?php echo tanggal($q); ?></h4>
					<div class="heading-elements">
						<ul class="list-inline mb-0">
							<li><a class="btn btn-icon btn-flat-success" href='excel-jam.php?p=reportbydate&q=<?php echo $_POST['q']; ?>&cerobong=<?php echo $_POST['cerobong']; ?>&cat=<?php echo $_POST['cat']; ?>&prm=<?php echo $prm; ?>'><i class="fa fa-file-excel-o"></i> Download .xls file</a></li>
						</ul>
					</div>
				</div>
				<div class="card-content">
					<div class="card-body">
						<div id="capture" align="center"><div id="all"></div></div>
						<div class="table-responsive">
							<table id="datatable2" class="table nowrap">
								<thead>
									<tr>
										<th class="text-center">No.</th>
										<th class="text-center">Cerobong</th>
										<th class="text-center">Parameter</th>
										<th class="text-center">Value</th>
										<th class="text-center">Waktu</th>
										<th class="text-center">Flow</th>
										<th class="text-center">Status</th>
										<th class="text-center">Fuel</th>
										<th class="text-center">Load</th>
										<th class="text-center">Status Sispek</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
}
?>

