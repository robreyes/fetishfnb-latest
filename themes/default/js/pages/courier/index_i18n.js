var post_flag = 1;
$('form#courier_form').on('submit', function(e) {
    e.preventDefault();


    var start_time  = $('#courier_start_time_1').val()+':'+$('#courier_start_time_2').val()+' '+$('#courier_start_time_3').val();
    var end_time    = $('#courier_end_time_1').val()+':'+$('#courier_end_time_2').val()+' '+$('#courier_end_time_3').val();

    $('#courier_start_time').val(start_time);
    $('#courier_end_time').val(end_time);

    if(post_flag == 1) {
        post_flag = 0;

        $('.form-line').removeClass('error');
        $('label').removeClass('text-danger');

        var formData = new FormData($(this)[0]);
        console.log($($(this)[0]).serializeArray());
        ajaxPostMultiPartCustom('process_courier', '#submit_loader', formData, function(response) {
            if(response.flag == 0) {
              console.log(response);
                $('#validation-error').show();
                $('#validation-error p').html(response.msg);
                $.each(JSON.parse(response.error_fields), (index, item) => {
                    $("input[name*='"+item+"'], select[name*='"+item+"'], textarea[name*='"+item+"']").closest('.form-line').addClass('error');
                    $('label.'+item).addClass('text-danger');
                });
                post_flag = 1;
                $('#submit_loader').remove();
            } else {
                setTimeout(function() {
                    window.location.href = site_url+'ebooking/finish_booking';
                }, 1000);
            }
        });
    }
    return false;

});

$(document).ready( function(){

  $('#courier_date').datepicker({
    'autoclose' : true,
  });

});
