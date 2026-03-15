<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
$(document).ready(function () {
	$('.select2').select2();
	$('.pickadate').pickadate({
		today: '',
		clear: '',
		close: '',
		format: 'mm/dd/yyyy',
		max: new Date(),
		editable: true
	});
	$('#todate').attr('disabled', true);
	$('body').on('change', '#fromdate', function() {
		$('#todate').attr('disabled', false);
		$('#todate').pickadate('picker').set('min', $(this).val());
		var today = new Date($(this).val());
		today.setDate(today.getDate() + 90);
		$('#todate').pickadate('picker').set('max', today);
		$('#todate').val('');
	});
	$('body').on('submit', '#form', function(e) {
		e.preventDefault();
		var fromdate = $('#fromdate').val();
		var todate = $('#todate').val();
		var cerobong = $('#cerobong').val();
		var cat = $('#cat').val();
		var prm = JSON.stringify($('#prm').val());
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/fetch.php',
			method : 'POST',
			data : $('#form').serialize(),
			beforeSend: function() {
				$('#submit_btn').attr('disabled', true);
				$('#my_data').html('');
			},
			success : function(data) {
				$('#submit_btn').attr('disabled', false);
				$('#my_data').html(data);
				$('#loading').hide();
				$('#datatable').DataTable().destroy();
				$('#datatable').DataTable({
					//dom:'<"row"<"col-sm-6" l><"col-sm-6" f>>t<"row"<"col-sm-6" i><"col-sm-6" p>>',
					responsive: true,
					autoWidth: false,
					language: { search: "",searchPlaceholder: "Search" },
					'processing' : true,
					'serverSide' : true,
					'order' : [0, 'desc'],
					'columnDefs' : [{
						'visible' : false,
						'targets' : 0
					}, {
						'targets' : 1,
						'data' : 1,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 2,
						'data' : 2,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 3,
						'data' : 3,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 4,
						'data' : 4,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 5,
						'data' : 5,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 6,
						'data' : 6,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 7,
						'data' : 7,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 8,
						'data' : 8,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}],
					'ajax' : 'page/view/<?php echo $p; ?>/action/ssp.php?fromdate='+fromdate+'&todate='+todate+'&cerobong='+cerobong+'&cat='+cat+'&prm='+prm
				});
				$('#datatable2').DataTable().destroy();
				$('#datatable2').DataTable({
					//dom:'<"row"<"col-sm-6" l><"col-sm-6" f>>t<"row"<"col-sm-6" i><"col-sm-6" p>>',
					responsive: true,
					autoWidth: false,
					language: { search: "",searchPlaceholder: "Search" },
					'processing' : true,
					'serverSide' : true,
					'order' : [0, 'desc'],
					'columnDefs' : [{
						'visible' : false,
						'targets' : 0
					}, {
						'targets' : 1,
						'data' : 1,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 2,
						'data' : 2,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 3,
						'data' : 3,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 4,
						'data' : 4,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 5,
						'data' : 5,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 6,
						'data' : 6,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 7,
						'data' : 7,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 8,
						'data' : 8,
						'render' : function (data, type, row, meta) {
							return '<div class="text-center">'+data+'</div>';
						}
					}, {
						'targets' : 9,
						'data' : 9,
						'render' : function (data, type, row, meta) {
							if (data == '') {
								return '<div class="text-center"><i class="fa fa-circle font-small-3 text-warning mr-50"></i>Belum Terkirim</div>';
							} else {
								return '<div class="text-center"><i class="fa fa-circle font-small-3 text-success mr-50"></i>Terkirim</div>';
							}
						}
					}],
					'ajax' : 'page/view/<?php echo $p; ?>/action/ssp2.php?fromdate='+fromdate+'&todate='+todate+'&cerobong='+cerobong+'&cat='+cat+'&prm='+prm
				});
				if (cat != 'all') {
					var all_options = {
						series: [],
						chart: {
							height: 350,
							type: 'line',
							zoom: {
								enabled: true
							}
						},
						//colors: ['#7367f0'],
						dataLabels: {
							enabled: false
						},
						stroke: {
							curve: 'smooth'
						},
						/* tooltip: {
							x: {
								format: 'dd MMM yyyy'
							},
						}, */
						markers: {
							size: 1
						},
						noData: {
							text: 'Loading...'
						},
						xaxis: {
							type: 'category',
							tickPlacement: 'on',
						}
					};
					var all_chart = new ApexCharts(document.querySelector('#all'), all_options);
					all_chart.render();
					
					$.getJSON('page/view/<?php echo $p; ?>/action/data.php?fromdate='+fromdate+'&todate='+todate+'&cerobong='+cerobong+'&cat='+cat+'&prm='+prm, function(response) {
						all_chart.updateSeries([{
							name: 'Average',
							data: response
						}])
					});
				}
				if (cat == 'all') {
					var all_options = {
						series: [],
						chart: {
							height: 350,
							type: 'line',
							zoom: {
								enabled: true
							}
						},
						dataLabels: {
							enabled: false
						},
						stroke: {
							curve: 'smooth'
						},
						tooltip: {
							x: {
								format: 'dd MMM yyyy HH:mm:ss'
							},
						},
						markers: {
							size: 1
						},
						noData: {
							text: 'Loading...'
						}
					};
					var all_chart = new ApexCharts(document.querySelector('#all'), all_options);
					all_chart.render();
					
					$.getJSON('page/view/<?php echo $p; ?>/action/data.php?fromdate='+fromdate+'&todate='+todate+'&cerobong='+cerobong+'&cat='+cat+'&prm='+prm, function(response) {
						all_chart.updateSeries([
						<?php
						$no = 0;
						$parameterallQuery = mysqli_query($con, "select * from parameter");
						while ($parameterallData = mysqli_fetch_array($parameterallQuery, MYSQLI_ASSOC)) {
							$no++;
						?>
						{
							name: response[0].name<?php echo $no; ?>,
							type: response[0].type<?php echo $no; ?>,
							data: response[0].data<?php echo $no; ?>
						},
						<?php
						}
						?>
						]);
						all_chart.updateOptions({
							xaxis: {
								categories: response[0].waktu,
								type: 'datetime',
								tickPlacement: 'on'
							}
						});
					});
				}
			}
		});
	});
	$('body').on('click', '#download_btn', function() {
		var action = $(this).attr('action');
		var id =  $(this).attr('value');
		html2canvas(document.getElementById('capture')).then(function (canvas) {
			var uri = canvas.toDataURL('image/png', 1);
			$.ajax({
				url : 'page/view/<?php echo $p; ?>/action/download.php?'+id+'',
				method : 'POST',
				data : {action:action, uri:uri},
				beforeSend: function() {
					$('#loading').show();
				},
				success : function(data) {
					$('#loading').hide();
					window.open(data, '_blank');
				}
			});
		});
	});
	setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
	}, 3000);
});
</script>

