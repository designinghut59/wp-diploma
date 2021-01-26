(function($){
  $("label[for='metavalue']").text("Label");
  $("#newmeta").find('textarea').hide();
  $("#newmeta").find('label[for=metavalue]').hide();
  $("textarea[id^='meta']").attr('readonly', true);

  
  $("#wp-generate-diploma").submit(function(event) {

        event.preventDefault();
        $(this).find("button[type=submit]").append('<i class="fa fa-gear fa-spin" style="font-size:24px"></i>');
        $(this).find("button[type=submit]").prop("disabled",true);
          var serialize_form = $(this).serialize();
            $.ajax({
              type:"POST",
              url: wp_diploma.ajax_url,
              data: serialize_form,
              dataType: 'json',
              success: function (response) {
                    $(this).find("button[type=submit]").children().remove();
                    $(this).find("button[type=submit]").prop("disabled",false);
                         if (response.status) {
                            window.location.href = response.filename;
                          }
                },
                    error: function (errorThrown) {
                       alert('error');
                        console.log(errorThrown);
                    },
            });
  });
})(jQuery)

