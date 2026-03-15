		<div class="sidenav-overlay"></div>
		<div class="drag-target"></div>
		<footer class="footer fixed-footer footer-light">
			<p class="clearfix blue-grey lighten-2 mb-0">
				<span class="float-md-left d-block d-md-inline-block mt-25">&copy; <?php echo date('Y'); ?><a class="text-bold-800 grey darken-2" href="#" target="_blank">CEMS</a>.</span>
				<span class="float-md-right d-none d-md-block">All Rights Reserved.</span>
				<button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
			</p>
			<div id="notif_session" style="display: none;"></div>
		</footer>
		<script src="app-assets/vendors/js/vendors.min.js"></script>
		<script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
		<script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
		<script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
		<script src="app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
		<script src="app-assets/vendors/js/extensions/toastr.min.js"></script>
		<script src="app-assets/vendors/js/charts/apexcharts.min.js"></script>
		<script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
		<script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
		<script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>
		<script src="app-assets/vendors/fullcalendar/main.min.js"></script>
		<script src="app-assets/vendors/fullcalendar/moment.js"></script>
		<script src="app-assets/js/core/app-menu.js"></script>
		<script src="app-assets/js/core/app.js"></script>
		<script src="app-assets/js/core/libraries/bootstrap.min.js"></script>
<?php
$script = 'page/view/'.$p.'/script.php';
if (file_exists($script)) {
	include $script;
}
?>
		<script>
			$(document).ready(function () {
				$('#notif_count').unbind('click').click(function () {
					var action = 'read';
					$.ajax({
						url : 'page/config/notif.php',
						method : 'POST',
						data : {action:action}
					});
				});
				/* setInterval(function(){
					$.ajax({
						url : 'page/view/notif/notif_session.php',
						method : 'POST',
						success : function(data) {
							if (data == 'autologout') {
								window.location = 'autologout';
							}
							console.log(data);
						}
					});
				}, 3000); */
			});
		</script>
	</body>
</html>
