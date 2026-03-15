<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
?>
<script>
$(document).ready(function () {
    $('.pickadate').pickadate({
        format: 'mm/dd/yyyy',
        editable: true
    });
    $('#fromtime').pickatime({
        format: 'HH:i',
        interval: 60,
        editable: true
    });
    $.ajax({
        url: "/page/view/kirim/action/getstatus.php",
        dataType: "json",
        type: "GET",
        success: function(data) {
            if (data.isKirim == '1') {
                $('#iskirim').prop('checked', true);
            } else {
                $('#iskirim').prop('checked', false);
            }
        }
    })
})

$(document).on( 'click', '.action-kirim', function () {
    if(document.getElementById('iskirim').checked) {
        iskirim = 1
    } else {
        iskirim = 0
    }
    $.ajax({
        url: "/page/view/kirim/action/action.php",
        dataType: "json",
        data: {iskirim: iskirim},
        type: "POST",
        success: function(data) {
            if (iskirim == 1) {
                toastr.success(data, 'Sukses hidupkan kirim data otomatis');
            } else {
                toastr.success(data, 'Sukses matikan kirim data otomatis');
            }
        }
    })
})

$(document).on( 'click', '.action-submit', function () {
    fromdate = $('#fromdate').val();
    fromtime = $('#fromtime').val();
    if(fromdate != '' && fromtime != ''){
        splitdate = fromdate.split("/")
        newdate = splitdate[2]+"-"+splitdate[0]+"-"+splitdate[1]
        datetime = newdate+' '+fromtime+":00"
        console.log(datetime)
        $.ajax({
            url: "/klhkmanual.php?datetime="+datetime,
            dataType: "json",
            type: "GET",
            success: function(data) {
                console.log(data)
                toastr.success(data.message, 'Sukses submit data');
            }
        })
    }else{
        toastr.warning("Submit data", 'Tanggal dan Waktu tidak boleh kosong');
    }
})
</script>