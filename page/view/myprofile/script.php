<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
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
				$('#submit_btn').text('Simpan');
				$('#submit_btn').attr('disabled', false);
				toastr.success(data, 'Success!');
			}
		});
	});
	setInterval(function(){
		$('#notif_count').load('page/view/notif/notif_count.php');
		$('#notif_data').load('page/view/notif/notif_data.php');
	}, 3000);
});
</script>
