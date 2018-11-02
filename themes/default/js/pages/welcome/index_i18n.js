$(function() {
	/*easy autocomplete*/
  var data = {
    'csrf_token' : csrf_token
  }
  var options = {
      url: function(phrase) {
        return site_url+'courses'+'/search_categories';
      },
      getValue: function(element) {
        return element.text;
      },
      ajaxSettings: {
        dataType: "JSON",
        method: "POST",
        data: {
          dataType: "json",
        },
      },
      preparePostData: function(data) {
        data.phrase     = $("#search-categories").val();
        data.csrf_token = csrf_token;
        return data;
      },
      template: {
          type: "links",
          fields: {
            link: "link",
          }
      },
      theme: "square",
      cssClasses: "sheroes",
      list: {
        showAnimation: {
          type: "slide",
        },
        hideAnimation: {
          type: "slide"
        }
      },
      requestDelay: 500
  };
  $("#search-categories").easyAutocomplete(options);
})

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

$(window).on('load', function() {
  equalheight('.course-detail-wrap');
});
$(window).resize(function(){
  equalheight('.course-detail-wrap');
});


$(window).on('load', function() {
  equalheight('.event-details');
});
$(window).resize(function(){
  equalheight('.event-details');
});

$(window).on('load', function() {
  equalheight('.blog-details');
});
$(window).resize(function(){
  equalheight('.blog-details');
});
$(window).ready(function() {
  if(Cookies.get('hideTheModal') == null)
  {
    // delay by 3 seconds
    setTimeout(function(){
        // make the modal appear
        $('#homeopt-in').modal({
          fadeDuration: 200,
          fadeDelay: 0.50
        });
    }, 3000);
  }
});

// Ajax form submit with validation errors
var post_flag = 1;
$('form#email-optin').on('submit', function(e) {
    e.preventDefault();

    if(post_flag == 1) {
        post_flag = 0;
        $('.form-line').removeClass('error');
        $('label').removeClass('text-danger');

        var formData = new FormData($(this)[0]);
        ajaxPostMultiPartCustom('welcome/save_contact', '#submit_loader', formData, function(response) {
            if(response.flag == 0) {
                $('#validation-error').show();
                $('#validation-error').addClass('text-danger');
                $('#validation-error p').html(response.msg);

                $.each(JSON.parse(response.error_fields), (index, item) => {
                    $("input[name*='"+item+"'], select[name*='"+item+"'], textarea[name*='"+item+"']").closest('.form-line').addClass('error');

                    if((item[item.length -2]+item[item.length -1]) == '[]')
                        $('label.'+item.slice(0,-2)).addClass('text-danger');
                    else
                        $('label.'+item).addClass('text-danger');

                });

                post_flag = 1;
                $('#submit_loader').empty();
            } else {
              $('#validation-error').show();
              $('#validation-error').removeClass('text-danger');
              $('#validation-error').addClass('text-success');
              $('#validation-error p').html(response.msg);
              Cookies.set('hideTheModal', 'true', { expires: 1 }); //disable for 24hours
              setTimeout(function() {
                  window.location.href = site_url;
              }, 3000);
            }
        });
    }
    return false;
});
