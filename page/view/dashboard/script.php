<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
	<?php
	$parameterQuery = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
	while ($parameterData = mysqli_fetch_array($parameterQuery, MYSQLI_ASSOC)) {
	?>
	var <?php echo $parameterData['parameter_code']; ?>_options = {
		series: [],
		chart: {
			height: 100,
			type: 'line',
			toolbar: {
				show: false,
			},
			sparkline: {
				enabled: true
			},
			/* grid: {
				show: true,
				padding: {
					left: 0,
					right: 0
				}
			}, */
		},
		//colors: ["<?php echo $parameterData['parameter_color']; ?>"],
		<?php
		if ($parameterData['parameter_code'] == 'NOx') {
			echo "colors: ['#bfbfbf', '#7367f0'],";
		}
		if ($parameterData['parameter_code'] == 'SO2') {
			echo "colors: ['#bfbfbf', '#28c76f'],";
		}
		if ($parameterData['parameter_code'] == 'PM') {
			echo "colors: ['#bfbfbf', '#ff9f43'],";
		}
		if ($parameterData['parameter_code'] == 'CO2') {
			echo "colors: ['#bfbfbf', '#00cfe8'],";
		}
		if ($parameterData['parameter_code'] == 'Hg') {
			echo "colors: ['#bfbfbf', '#ff0000'],";
		}
		if ($parameterData['parameter_code'] == 'O2') {
			echo "colors: ['#bfbfbf', '#ffff00'],";
		}
		?>
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth',
			width: 2.5
		},
		/* fill: {
			type: 'gradient',
			gradient: {
				shadeIntensity: 0.9,
				opacityFrom: 0.7,
				opacityTo: 0.5,
				stops: [0, 80, 100]
			}
		}, */
		noData: {
			text: 'Loading...'
		},
		xaxis: {
			labels: {
				show: false,
			},
			axisBorder: {
				show: false,
			}
		},
		yaxis: [{
			y: 0,
			offsetX: 0,
			offsetY: 0,
			padding: {
				left: 0,
				right: 0
			}
		}],
		tooltip: {
			enabled: true
		},
	}
	
	var <?php echo $parameterData['parameter_code']; ?>_chart = new ApexCharts(
		document.querySelector("#<?php echo $parameterData['parameter_code']; ?>"), <?php echo $parameterData['parameter_code']; ?>_options
	);
	<?php echo $parameterData['parameter_code']; ?>_chart.render();
	<?php
	}
	?>
	
	var flow_options = {
		series: [],
		chart: {
			height: 100,
			type: 'line',
			toolbar: {
				show: false,
			},
			sparkline: {
				enabled: true
			},
			/* grid: {
				show: true,
				padding: {
					left: 0,
					right: 0
				}
			}, */
		},
		colors: ['#bfbfbf', '#7367f0'],
		dataLabels: {
			enabled: false
		},
		stroke: {
			curve: 'smooth',
			width: 2.5
		},
		/* fill: {
			type: 'gradient',
			gradient: {
				shadeIntensity: 0.9,
				opacityFrom: 0.7,
				opacityTo: 0.5,
				stops: [0, 80, 100]
			}
		}, */
		noData: {
			text: 'Loading...'
		},
		xaxis: {
			labels: {
				show: false,
			},
			axisBorder: {
				show: false,
			}
		},
		yaxis: [{
			y: 0,
			offsetX: 0,
			offsetY: 0,
			padding: {
				left: 0,
				right: 0
			}
		}],
		tooltip: {
			enabled: true
		},
	}
	
	var flow_chart = new ApexCharts(
		document.querySelector("#flow"), flow_options
	);
	flow_chart.render();
	
	<?php
	$cerobongQuery = mysqli_query($con, "select * from cerobong");
	while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
	?>
	var all<?php echo $cerobongData['cerobong_id']; ?>_options = {
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
			"#bfbfbf"
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
	var all<?php echo $cerobongData['cerobong_id']; ?>_chart = new ApexCharts(document.querySelector("#all<?php echo $cerobongData['cerobong_id']; ?>"), all<?php echo $cerobongData['cerobong_id']; ?>_options);
	all<?php echo $cerobongData['cerobong_id']; ?>_chart.render();
	<?php
	}
	?>
	//setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
		$('#mini_alert').load('page/view/<?php echo $p; ?>/action/mini_alert.php');
		$('#mini_info').load('page/view/<?php echo $p; ?>/action/mini_info.php');
		<?php
		$parameter2Query = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
		while ($parameter2Data = mysqli_fetch_array($parameter2Query, MYSQLI_ASSOC)) {
		?>
		$.getJSON("page/view/<?php echo $p; ?>/action/data.php?cat=param&q=<?php echo $parameter2Data['parameter_code']; ?>", function(response) {
			<?php echo $parameter2Data['parameter_code']; ?>_chart.updateSeries([
			<?php
			$cerobongQuery = mysqli_query($con, "select * from cerobong");
			while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
			?>
			{
				name: response[0].name<?php echo $cerobongData['cerobong_id']; ?>,
				data: response[0].data<?php echo $cerobongData['cerobong_id']; ?>
			},
			<?php
			}
			?>
			]);
			<?php echo $parameter2Data['parameter_code']; ?>_chart.updateOptions({
				xaxis: {
					categories: response[0].waktu,
					type: 'datetime',
					tickPlacement: 'on'
				}
			});
		});
		<?php
		}
		?>
		
		$.getJSON("page/view/dashboard/action/data.php?cat=param&q=flow", function(response) {
			flow_chart.updateSeries([
			<?php
			$cerobongQuery = mysqli_query($con, "select * from cerobong");
			while ($cerobongData = mysqli_fetch_array($cerobongQuery, MYSQLI_ASSOC)) {
			?>
			{
				name: response[0].name<?php echo $cerobongData['cerobong_id']; ?>,
				data: response[0].data<?php echo $cerobongData['cerobong_id']; ?>
			},
			<?php
			}
			?>
			]);
			flow_chart.updateOptions({
				xaxis: {
					categories: response[0].waktu,
					type: 'datetime',
					tickPlacement: 'on'
				}
			});
		});
		
		<?php
		$cerobong2Query = mysqli_query($con, "select * from cerobong");
		while ($cerobong2Data = mysqli_fetch_array($cerobong2Query, MYSQLI_ASSOC)) {
		?>
		$.getJSON("page/view/<?php echo $p; ?>/action/data.php?cat=all&q=<?php echo $cerobong2Data['cerobong_id']; ?>", function(response) {
			all<?php echo $cerobong2Data['cerobong_id']; ?>_chart.updateSeries([
			<?php
			$parameter3Query = mysqli_query($con, "select * from parameter where parameter_status = 'active'");
			while ($parameter3Data = mysqli_fetch_array($parameter3Query, MYSQLI_ASSOC)) {
			?>
			{
				name: response[0].name<?php echo $parameter3Data['parameter_id']; ?>,
				type: response[0].type<?php echo $parameter3Data['parameter_id']; ?>,
				data: response[0].data<?php echo $parameter3Data['parameter_id']; ?>
			},
			<?php
			}
			?>
			{
				name: response[0].nameflow,
				type: response[0].typeflow,
				data: response[0].dataflow
			}
			]);
			all<?php echo $cerobong2Data['cerobong_id']; ?>_chart.updateOptions({
				xaxis: {
					categories: response[0].waktu,
					type: 'datetime',
					tickPlacement: 'on'
				}
			});
		});
		<?php
		}
		?>
	//}, 60000);
	setInterval(function(){
		location.reload();
	}, 300000);
});
</script>