<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		editable: false,
		eventBorderColor: '#fff',
		events: {
			url: 'page/view/<?php echo $p; ?>/action/json.php',
        },
		eventClick: function(arg) {
			//alert(moment(arg.event.start).format('YYYY-MM-DD'));
			var action = 'detail';
			var id =  moment(arg.event.start).format('YYYY-MM-DD');
			$.ajax({
				url : 'page/view/<?php echo $p; ?>/action/fetch.php',
				method : 'POST',
				data : {action:action, id:id},
				success : function(data) {
					$('#my_form').html(data);
					$('#my_table').hide();
				}
			});
		}
    });
    calendar.render();
	$('body').on('click', '#close_btn', function() {
		$('#my_form').html('');
		$('#my_table').show();
	});
  });
</script>
