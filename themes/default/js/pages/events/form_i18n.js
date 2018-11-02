/*
 * Author: DK
 * Description: Batches create.js
 **/

 // Multiple images preview in browser
var imagesPreview = function(input, placeToInsertImagePreview) {

    if (input.files) {
        var filesAmount = input.files.length;
        $('.gallery').html('');
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function(event) {
                $($.parseHTML('<img class="col-sm-2 img-responsive thumbnail">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
            }

            reader.readAsDataURL(input.files[i]);
        }
    }

};

$(function () {
    "use strict";

    $('#images').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });

    if(tutors)
        $("#tutors").val(tutors).trigger("change");

    $('.help-recursive').on('click', function() {
        swal({
            title: "{{events_recurring_help}}",
            text: `{{events_recurring_help_a}}`,
            html: true
        });
    });

    $('#start_end_date').daterangepicker();

    $('#recurring').change(function() {
        if($(this).is(":checked")) {
            $('#weekdays_select').show();
            $('#recurring_type_select').show();
            $('#timeslot_type_select').show();
            $('#timeslot_timepicker').show();
        } else {
            $('#weekdays_select').hide();
            $('#recurring_type_select').hide();
            $('#timeslot_type_select').hide();
            $('#timeslot_timepicker').hide();
        }
    }).trigger('change');

    $('#timeslot').change(function() {
        if($(this).is(":checked")) {
          $('#timeslot_timepicker').show();
          $('.timeslot_add').show();
        } else {
          $('#timeslot_timepicker').hide();
          $('.timeslot_add').hide();
        }
    }).trigger('change');

    function addSlot(slot)
    {

      var slotcount  = 0;
          slotcount += parseFloat(slot);
          slotcount += parseFloat(1);

      var timeslotform    =
        '<div class="col-md-2 form-control-label">'+
            '<label for="start_time_1" class="start_time_1">From</label>'+
        '</div>'+
        '<div class="timeslot-start col-md-4 padding-0">'+
            '<div class="timeslot_form col-sm-12 input-group">'+
              '<div class="col-sm-4 input-join padding-0">'+
                '<select name="timeslot_start_time_hr[]" id="timeslot_start_time_hr_'+slotcount+'" class="form-control show-tick">'+
                  '<option value="01">01</option>'+
                  '<option value="02">02</option>'+
                  '<option value="03">03</option>'+
                  '<option value="04">04</option>'+
                  '<option value="05">05</option>'+
                  '<option value="06">06</option>'+
                  '<option value="07">07</option>'+
                  '<option value="08">08</option>'+
                  '<option value="09">09</option>'+
                  '<option value="10">10</option>'+
                  '<option value="11">11</option>'+
                  '<option value="12">12</option>'+
                '</select>'+
                '</div>'+
              '<div class="col-sm-4 input-join padding-0">'+
                '<select name="timeslot_start_time_min[]" id="timeslot_start_time_min_'+slotcount+'" class="form-control show-tick">'+
                  '<option value="00">00</option>'+
                  '<option value="30">30</option>'+
                '</select>'+
              '</div>'+
              '<div class="col-sm-4 input-join padding-0">'+
                '<select name="timeslot_start_time_d[]" id="timeslot_start_time_d_'+slotcount+'" class="form-control show-tick">'+
                  '<option value="AM">AM</option>'+
                  '<option value="PM">PM</option>'+
                '</select>'+
              '</div>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-1 form-control-label">'+
            '<label for="end_time_1" class="end_time_1">To</label>'+
        '</div>'+
        '<div class="timeslot-end col-md-5 padding-0">'+
          '<div class="timeslot_form col-md-12 input-group">'+
            '<div class="col-sm-3 input-join padding-0">'+
              '<select name="timeslot_end_time_hr[]" id="timeslot_end_time_hr_'+slotcount+'" class="form-control show-tick">'+
                '<option value="01">01</option>'+
                '<option value="02">02</option>'+
                '<option value="03">03</option>'+
                '<option value="04">04</option>'+
                '<option value="05">05</option>'+
                '<option value="06">06</option>'+
                '<option value="07">07</option>'+
                '<option value="08">08</option>'+
                '<option value="09">09</option>'+
                '<option value="10">10</option>'+
                '<option value="11">11</option>'+
                '<option value="12">12</option>'+
              '</select>'+
              '</div>'+
            '<div class="col-sm-3 input-join padding-0">'+
              '<select name="timeslot_end_time_min[]" id="timeslot_end_time_min_'+slotcount+'" class="form-control show-tick">'+
                '<option value="00">00</option>'+
                '<option value="30">30</option>'+
              '</select>'+
            '</div>'+
            '<div class="col-sm-3 input-join padding-0">'+
                '<select name="timeslot_end_time_d[]" id="timeslot_end_time_d_'+slotcount+'" class="form-control show-tick">'+
                  '<option value="AM">AM</option>'+
                  '<option value="PM">PM</option>'+
                '</select>'+
            '</div>'+
            '<div class="col-sm-2 input-join padding-0" style="padding-left:15px;"><input type="number" name="timeslot_capacity[]" value="1" id="timeslot_slots_'+slotcount+'" placeholder="Slots" class="form-control"></div>'+
            '<div class="col-sm-1 input-join padding-0"><a class="timeslot_rem" href="JavaScript:void(0);" data-timeslot="'+slotcount+'"><i class="fa fa-trash" aria-hidden="true"></i></a></div>'+
          '</div>'+
        '</div>';

      var timeslot_hidden =
      '<input type="hidden" name="timeslots_start_time[]" value="" class="timeslot-hidden" data-timeslot="'+slotcount+'">'+
      '<input type="hidden" name="timeslots_end_time[]" value="" class="timeslot-hidden" data-timeslot="'+slotcount+'">'+
      '<input type="hidden" name="timeslots_slot[]" value="" class="timeslot-hidden" data-timeslot="'+slotcount+'">';

      $('#timeslothidden').append(timeslot_hidden);

      $('#timeslot_timepicker').append(
        '<div class="timeslot_select"  data-timeslot="'+slotcount+'">'+timeslotform+'</div>'
      );

      $('.show-tick').selectpicker();

      console.log(slot);

      var timehidden       = $('#timeslothidden').html();

      $('.timeslot_add.btn').attr('data-pressed', slotcount);
    };

    //TinyMCE
    tinymce.init({
        selector: "textarea.tinymce",
        theme: "modern",
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = base_url+'/themes/admin/plugins/tinymce';

    // Ajax form submit with validation errors
    var post_flag = 1;
    $('form#form-create').on('submit', function(e) {
        e.preventDefault();

        var start_time  = $('#start_time_1').val()+':'+$('#start_time_2').val()+' '+$('#start_time_3').val();
        var end_time    = $('#end_time_1').val()+':'+$('#end_time_2').val()+' '+$('#end_time_3').val();

        $('#start_time').val(start_time);
        $('#end_time').val(end_time);


        $('.timeslot_select').each(function(){
          var slotnumber           = $(this).attr('data-timeslot');
          var slotstarttime        = $('#timeslot_start_time_hr_'+slotnumber).val()+':'+$('#timeslot_start_time_min_'+slotnumber).val()+' '+$('#timeslot_start_time_d_'+slotnumber).val();
          var slotendtime          = $('#timeslot_end_time_hr_'+slotnumber).val()+':'+$('#timeslot_end_time_min_'+slotnumber).val()+' '+$('#timeslot_end_time_d_'+slotnumber).val();
          var slotcapacity         = $('#timeslot_slots_'+slotnumber).val();

          $('input[name^="timeslots_start_time"][data-timeslot="'+slotnumber+'"]').val(slotstarttime);
          $('input[name^="timeslots_end_time"][data-timeslot="'+slotnumber+'"]').val(slotendtime);
          $('input[name^="timeslots_slot"][data-timeslot="'+slotnumber+'"]').val(slotcapacity);
        });

        if(post_flag == 1) {
            post_flag = 0;

            $('.form-line').removeClass('error');
            $('label').removeClass('text-danger');

            var formData = new FormData($(this)[0]);
            console.log($($(this)[0]).serializeArray());
            ajaxPostMultiPartCustom('save', '#submit_loader', formData, function(response) {
                if(response.flag == 0) {
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
                        window.location.href = site_url+uri_seg_1+'/'+uri_seg_2+'/'+uri_seg_3;
                    }, 1000);
                }
            });
        }
        return false;
    });

    $(document).ready(function(){
      var timeslots = $('div.timeslot_select').length;

      if(timeslots != 0){
        $('a.timeslot_add').attr('data-pressed', timeslots);
      }

      $('a.timeslot_add').on('click', function(){

        var thisslot = $(this).attr('data-pressed');
        addSlot(thisslot);

        return false;
      });

      $(document).on('click', '.timeslot_rem', function(){
        "use strict";
          var timeslot = $(this).attr('data-timeslot');
          $('div.timeslot_select[data-timeslot="'+timeslot+'"]').remove();
          $('input.timeslot-hidden[data-timeslot="'+timeslot+'"]').remove();
      });
    });

});
