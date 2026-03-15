<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
	fetch_db('all');
	function fetch_db(q) {
		$('#datatable').DataTable().destroy();
		$('#datatable').DataTable({
			//dom:'<"row"<"col-sm-6" l><"col-sm-6" f>>t<"row"<"col-sm-6" i><"col-sm-6" p>>',
			responsive: true,
			autoWidth: false,
			language: { search: "",searchPlaceholder: "Search" },
			'processing' : true,
			'serverSide' : true,
			//'bFilter' : false,
			//'lengthChange' : false,
			'order' : [5, 'desc'],
			'columnDefs' : [{
				'visible' : false,
				'targets' : [0, 2, 3, 4, 5, 6]
			}, {
				'targets' : 1,
				'data' : 1,
				'render' : function (data, type, row, meta) {
					var render1 = '<div class="d-flex justify-content-start align-items-center mb-1"><div class="user-page-info"><h6 id="view_btn" class="cursor-pointer mb-0" value="'+row[6]+'">'+row[1]+'<br><small>'+row[5]+'</small><br>';
					if (row[2] == 'troubleshoot') {
						var render2 = '<span class="badge badge-pill badge-light-primary"><span class="bullet bullet-primary bullet-xs"></span> '+row[2]+'</span></h6>';
					}
					if (row[2] == 'service') {
						var render2 = '<span class="badge badge-pill badge-light-warning"><span class="bullet bullet-warning bullet-xs"></span> '+row[2]+'</span></h6>';
					}
					if (row[2] == 'maintenance') {
						var render2 = '<span class="badge badge-pill badge-light-danger"><span class="bullet bullet-danger bullet-xs"></span> '+row[2]+'</span></h6>';
					}
					var render3 = '</div><div class="ml-auto cursor-pointer">';
					if (row[4] == '') {
						var render4 = '<i id="star_btn" class="feather icon-star mr-50" value="'+row[6]+'"></i> <i id="trash_btn" class="feather icon-trash" value="'+row[6]+'"></i></div></div>';
					}
					if (row[4] == 'star') {
						var render4 = '<i id="unstar_btn" class="feather icon-star text-warning mr-50" value="'+row[6]+'"></i> <i id="trash_btn" class="feather icon-trash" value="'+row[6]+'"></i></div></div>';
					}
					if (row[4] == 'trash') {
						var render4 = '</div></div>';
					}
					if (row[4] == 'complete') {
						var render4 = '<i class="feather icon-check text-success mr-50"></i></div></div>';
					}
					return render1+render2+render3+render4;
				}
			}],
			'ajax' : 'page/view/<?php echo $p; ?>/action/ssp.php?q='+q
		});
	}
	$('body').on('input', '#search', function() {
		var search = $(this).val();
		$('#datatable_filter input').trigger('input');
		$('#datatable_filter input').val(search);
	});
	$('body').on('click', '#activity_btn', function() {
		$('#my_form').html('');
		$('#my_table').show();
		var q = $(this).val();
		fetch_db(q);
	});
	$('body').on('click', '#star_btn', function() {
		var action = 'star';
		var id =  $(this).attr('value');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/post.php',
			method : 'POST',
			data : {action:action, id:id},
			success : function(data) {
				toastr.success(data, 'Success!');
				fetch_db('all');
			}
		});
	});
	$('body').on('click', '#unstar_btn', function() {
		var action = 'unstar';
		var id =  $(this).attr('value');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/post.php',
			method : 'POST',
			data : {action:action, id:id},
			success : function(data) {
				toastr.success(data, 'Success!');
				fetch_db('all');
			}
		});
	});
	$('body').on('click', '#trash_btn', function() {
		var action = 'trash';
		var id =  $(this).attr('value');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/post.php',
			method : 'POST',
			data : {action:action, id:id},
			success : function(data) {
				toastr.success(data, 'Success!');
				fetch_db('all');
			}
		});
	});
	$('body').on('click', '#complete_btn', function() {
		var action = 'complete';
		var id =  $(this).attr('value');
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/post.php',
			method : 'POST',
			data : {action:action, id:id},
			success : function(data) {
				$('#my_form').html('');
				$('#my_table').show();
				toastr.success(data, 'Success!');
				fetch_db('all');
			}
		});
	});
	$('body').on('click', '#add_btn', function() {
		var action = 'create';
		$.ajax({
			url : 'page/view/<?php echo $p; ?>/action/fetch.php',
			method : 'POST',
			data : {action:action},
			success : function(data) {
				$('#my_form').html(data);
				$('#my_table').hide();
				$('.select2').select2();
			}
		});
	});
	$('body').on('click', '#view_btn', function() {
		var action = 'view';
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
				$('#my_form').html('');
				$('#my_table').show();
				toastr.success(data, 'Success!');
				fetch_db('all');
			}
		});
	});
	setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
	}, 3000);
});
</script>
