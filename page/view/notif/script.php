<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
	$('#loading').hide();
	fetch_db();
	function fetch_db() {
		var q = $('#q').val();
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
				'targets' : [0, 11]
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
					return '<div class="text-center">'+data+'</div>';
				}
			}, {
				'targets' : 10,
				'data' : 10,
				'render' : function (data, type, row, meta) {
					return '<div class="text-center">'+data+'</div>';
				}
			}, {
				'targets' : 11,
				'data' : 11,
				'render' : function (data, type, row, meta) {
					return '<i class="fa fa-circle font-small-3 text-success mr-50"></i>Terkirim';
				}
			}],
			'ajax' : 'page/view/<?php echo $p; ?>/action/ssp.php?q='+q,
		});
	}
	$('body').on('click', '#download_btn', function() {
		var action = $(this).attr('action');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/download.php',
			method : 'POST',
			data : {action:action},
			beforeSend: function() {
				$('#loading').show();
			},
			success : function(data) {
				$('#loading').hide();
				window.open(data, '_blank');
			}
		});
	});
	setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
	}, 3000);
	
});
</script>
