$(document).ready(function () {
	$('#login_form').keydown(function(e) {
		if (e.keyCode === 13) {
			$('#login_btn').click();
		}
	});
	$('#login_btn').click(function(e) {
		var user_email = $('#user_email').val();
		var user_pass = $('#user_pass').val();
		$.ajax({
			url: 'page/view/login/action/post.php',
			method: 'post',
			data: {user_email:user_email, user_pass:user_pass},
			beforeSend: function() {
				$('#login_btn').text('Loading');
				$('#login_btn').attr('disabled', true);
			},
			success:function(data) {
				if (data == 'ok') {
					window.location = './';
				}
				else if (data == 'double') {
					window.location = 'double';
				}
				else {
					$('#login_btn').text('Login');
					$('#login_btn').attr('disabled', false);
					toastr.error('Invalid email or password.', 'Error!');
				}
			}
		});
	});
});
