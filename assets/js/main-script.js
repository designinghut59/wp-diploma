(function($){
  $("label[for='metavalue']").text("Label");
  $("#newmeta").find('textarea').hide();
  $("#newmeta").find('label[for=metavalue]').hide();
  $("textarea[id^='meta']").attr('readonly', true);

  
  $("#wp-generate-diploma").submit(function(event) {

        event.preventDefault();
        $(this).find("button[type=submit]").append('<i class="fa fa-gear fa-spin" style="font-size:24px"></i>');
          var serialize_form = $(this).serialize();
            $.ajax({
              type:"POST",
              url: wp_diploma.ajax_url,
              data: serialize_form,
              dataType: 'json',
              success: function (response) {
        $(this).find("button[type=submit]").children().remove();
                        console.log(response);
                        if (response.status) {
                            alert(response.message);
                          }
                },
                    error: function (errorThrown) {
                       alert('error');
                        console.log(errorThrown);
                    },
            });
  });
  $("#bulk_create_btn").click(function(event) {
        event.preventDefault();
        $(this).append('<i class="fa fa-gear fa-spin" style="font-size:24px"></i>');
          var seriaize_form = $("#bulk_create")[0];
          var $bulk_form = $("#bulk_create")[0];
            $.ajax({
                type:"POST",
                url: wp_diploma.ajax_url,
                data: new FormData($bulk_form),
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
              success: function (response) {
                  $(this).children().remove();
                  console.log(response);
                    if (response.status) {
                        alert('success')
                      }
                },
                    error: function (errorThrown) {
                       alert('error');
                        console.log(errorThrown);
                    },
            });
  });
})(jQuery)

