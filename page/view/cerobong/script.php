<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
	fetch_db();
	fetch_db_status();
	function fetch_db() {
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
					if (data == '') {
						return '<div class="text-center"><i class="fa fa-circle font-small-3 text-warning mr-50"></i>Belum Terkirim</div>';
					} else {
						return '<div class="text-center"><i class="fa fa-circle font-small-3 text-success mr-50"></i>Terkirim</div>';
					}
				}
			}],
			'ajax' : 'page/view/<?php echo $p; ?>/action/ssp.php?q=<?php echo $q; ?>'
		});
	}
	function fetch_db_status() {
		$('#datatablestatus').DataTable().destroy();
		$('#datatablestatus').DataTable({
			//dom:'<"row"<"col-sm-6" l><"col-sm-6" f>>t<"row"<"col-sm-6" i><"col-sm-6" p>>',
			responsive: true,
			autoWidth: false,
			'processing' : true,
			'serverSide' : true,
			'bFilter'	 : false,
			'columnDefs' : [{
				'targets' : 0,
				'data' : 0,
				'render' : function (data, type, row, meta) {
					return '<div class="text-center">'+data+'</div>';
				}
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
					if (data == '') {
						return '<div class="text-center"><i class="fa fa-circle font-small-3 text-warning mr-50"></i>Belum Terkirim</div>';
					} else {
						return '<div class="text-center"><i class="fa fa-circle font-small-3 text-success mr-50"></i>Terkirim</div>';
					}
				}
			}],
			'ajax' : 'page/view/<?php echo $p; ?>/action/sspstatus.php?q=<?php echo $q; ?>'
		});
	}
	<?php
	$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
	while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
	?>
	var <?php echo $parameterData['parameter_code']; ?>_options = {
		series: [],
		chart: {
			height: 350,
			type: 'line',
			zoom: {
				enabled: true
			}
		},
		colors: ["<?php echo $parameterData['parameter_color']; ?>"],
		annotations: {
			yaxis: [{
				y: <?php echo $parameterData['parameter_threshold']; ?>,
				borderColor: '#ff0000',
				label: {
					borderColor: '#ff0000',
					style: {
						color: '#fff',
						background: '#ff0000'
					},
					text: 'Threshold'
				}
			}]
		},
		yaxis : {
			min: 0,
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
		},
		xaxis: {
			type: 'datetime',
			tickPlacement: 'on',
		}
	};
	var <?php echo $parameterData['parameter_code']; ?>_chart = new ApexCharts(document.querySelector("#<?php echo $parameterData['parameter_code']; ?>"), <?php echo $parameterData['parameter_code']; ?>_options);
	<?php echo $parameterData['parameter_code']; ?>_chart.render();
	<?php
	}
	?>
	
	//-----------------------------------------------------------------------------------//
	
	var all_options = {
		series: [],
		chart: {
			height: 350,
			type: 'line',
			zoom: {
				enabled: true
			}
		},
		colors: [
		<?php
		$colorQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
		while ($colorData = mysqli_fetch_array($colorQuery, MYSQLI_ASSOC)) {
		?>
			"<?php echo $colorData['parameter_color']; ?>",
		<?php
		}
		?>
		],
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
	
	//-----------------------------------------------------------------------------------//
	
	//setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
		<?php
		$parameter2Query = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
		while ($parameter2Data = mysqli_fetch_array($parameter2Query, MYSQLI_ASSOC)) {
		?>
		$.getJSON("page/view/<?php echo $p; ?>/action/data.php?cat=<?php echo $parameter2Data['parameter_code']; ?>&q=<?php echo $q; ?>", function(response) {
			function getMax(response, prop) {
				var max;
				for (var i=0 ; i<response.length ; i++) {
					if (!max || parseInt(response[i][prop]) > parseInt(max[prop]))
						max = response[i];
				}
				return max;
			}
		
			var maxY = getMax(response, "y");

			var data_high = maxY.y;
			var threshold = <?php echo $parameter2Data['parameter_threshold']; ?>;
			var max_high = 0;
			
			if (data_high > threshold){	
				var tambahan = 0.1 * data_high;		
				max_high = parseFloat(data_high,2) + parseFloat(tambahan,2);
			}else {
				max_high = threshold;
			}
			<?php echo $parameter2Data['parameter_code']; ?>_chart.updateSeries([{
				name: "<?php echo $parameter2Data['parameter_name']; ?>",
				data: response
			}])
			<?php echo $parameter2Data['parameter_code']; ?>_chart.updateOptions({
				
				yaxis : {
					min: 0,
					max: max_high
				}
			})
		});
		<?php
		}
		?>
		$.getJSON('page/view/<?php echo $p; ?>/action/data.php?cat=all&q=<?php echo $q; ?>', function(response) {
			all_chart.updateSeries([
			<?php
			$parameterallQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
			while ($parameterallData = mysqli_fetch_array($parameterallQuery, MYSQLI_ASSOC)) {
			?>
			{
				name: response[0].name<?php echo $parameterallData['parameter_id']; ?>,
				type: response[0].type<?php echo $parameterallData['parameter_id']; ?>,
				data: response[0].data<?php echo $parameterallData['parameter_id']; ?>
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
	//}, 60000);
	setInterval(function(){
		location.reload();
	}, 300000);
});
</script>