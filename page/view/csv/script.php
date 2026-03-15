<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
   $('body').on('submit', '#form', function(e) {
		e.preventDefault();
		var formData = new FormData();
		formData.append('file', $('#csv_file')[0].files[0]);
		formData.append('action', 'upload');
		$.ajax({              
			url: 'page/view/<?php echo $p; ?>/action/post.php',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function() {
				$('#submit_btn').text('Loading');
				$('#submit_btn').attr('disabled', true);
			},
			success : function(data) {
				$('#submit_btn').text('Upload');
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
