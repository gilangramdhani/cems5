$(document).ready(function () {
	$('body').on('click', '.verify_btn', function() {
		var action = $(this).attr('action');
		$.ajax({
			url : 'page/view/double/action/post.php',
			method : 'POST',
			data : {action:action},
			beforeSend: function() {
				$('.verify_btn').text('Loading');
				$('.verify_btn').attr('disabled', true);
			},
			success : function(data) {
				window.location = './';
			}
		});
	});
});
