<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
	fetch_db();
	function fetch_db() {
		$('#datatable').DataTable().destroy();
		$('#datatable').DataTable({
			//dom:'<"row"<"col-sm-6" l><"col-sm-6" f>>t<"row"<"col-sm-6" i><"col-sm-6" p>>',
			responsive: true,
			autoWidth: false,
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
					if (data == 'active') {
						return '<div class="text-center"><span class="badge badge-success">active</span></div>';
					}
					if (data == 'calibrate') {
						return '<div class="text-center"><span class="badge badge-warning">'+data+'</span></div>';
					}
					if (data == 'maintenance') {
						return '<div class="text-center"><span class="badge badge-danger">'+data+'</span></div>';
					}
				}
			}, {
				'targets' : 3,
				'data' : 3,
				'render' : function (data, type, row, meta) {
					if (row[2] == 'active') {
						return '<div class="text-center">'+data+'</div>';
					}
					if (row[2] != 'active') {
						return '<div class="text-center">active</div>';
					}
				}
			}, {
				'targets' : 4,
				'data' : 4,
				'render' : function (data, type, row, meta) {
					if (data == null) {
						data = '0000-00-00 00:00:00';
					}
					return '<div class="text-center">'+data+'</div>';
				}
			}, {
				'targets' : 5,
				'data' : 5,
				'render' : function (data, type, row, meta) {
					if (data == null) {
						data = '0000-00-00 00:00:00';
					}
					return '<div class="text-center">'+data+'</div>';
				}
			}, {
				'targets' : 6,
				'data' : 6,
				'render' : function (data, type, row, meta) {
					if (data == null) {
						data = '';
					}
					return '<div class="text-center">'+data+'</div>';
					
				}
			}, {
				'targets' : 7,
				'data' : 7,
				'render' : function (data, type, row, meta) {
					return '<div class="text-center"><button id="view_btn" type="button" class="btn btn-icon btn-flat-primary" action="view" value="'+data+'"><i class="feather icon-list"></i></button> <button id="edit_btn" type="button" class="btn btn-icon btn-flat-warning" action="update" value="'+data+'"><i class="feather icon-edit"></i></button></div>';
				}
			}],
			'ajax' : 'page/view/<?php echo $p; ?>/action/ssp.php'
		});
	}
	$('body').on('click', '#edit_btn', function() {
		var action = $(this).attr('action');
		var id =  $(this).attr('value');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/fetch.php',
			method : 'POST',
			data : {action:action, id:id},
			success : function(data) {
				$('#my_form').html(data);
				$('#my_table').hide();
				$('.select2').select2();
				$('.pickadate').pickadate({
					format: 'mm/dd/yyyy',
					editable: true,
					min: true
					//disable:[{from: [0, 0, 0], to: true}, 1]
				});
				$('#fromtime').pickatime({
					format: 'HH:i',
					editable: true,
					min: +2
				});
				$('#totime').pickatime({
					format: 'HH:i',
					editable: true,
				});
				if ($('#cerobong_status').val() == 'active') {
					$('#fromdate, #fromtime, #todate, #totime').prop('disabled', true);
					$('#fromdate, #fromtime, #todate, #totime').val('');
				}
				if ($('#cerobong_status').val() == 'calibrate') {
					$('#fromdate, #fromtime, #todate, #totime').prop('disabled', false);
				}
				if ($('#cerobong_status').val() == 'maintenance') {
					$('#fromdate, #fromtime, #todate, #totime').prop('disabled', false);
				}
			}
		});
	});
	$('body').on('click', '#view_btn', function() {
		var action = $(this).attr('action');
		var id =  $(this).attr('value');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/fetch.php',
			method : 'POST',
			data : {action:action, id:id},
			success : function(data) {
				$('#my_form').html(data);
				$('#my_table').hide();
			}
		});
	});
	$('body').on('change', '#cerobong_status', function() {
		if ($(this).val() == 'active') {
			$('#fromdate, #fromtime, #todate, #totime').prop('disabled', true);
			$('#fromdate, #fromtime, #todate, #totime').val('');
		}
		if ($(this).val() == 'calibrate') {
			$('#fromdate, #fromtime, #todate, #totime').prop('disabled', false);
		}
		if ($(this).val() == 'maintenance') {
			$('#fromdate, #fromtime, #todate, #totime').prop('disabled', false);
		}
	});
	$('body').on('click', '#close_btn', function() {
		$('#my_form').html('');
		$('#my_table').show();
	});
	$('body').on('submit', '#form', function(e) {
		e.preventDefault();
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/post.php',
			method : 'POST',
			data : $('#form').serialize(),
			beforeSend: function() {
				$('#submit_btn').text('Loading');
				$('#submit_btn').attr('disabled', true);
			},
			success : function(data) {
				$('#close_btn').click();
				toastr.success(data, 'Success!');
				fetch_db();
			}
		});
	});
	setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
	}, 3000);
});
</script>
