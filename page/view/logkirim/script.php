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
			}],
			'ajax' : 'page/view/<?php echo $p; ?>/action/ssp.php'
		});
	}
	setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
	}, 30000);
});
</script>
