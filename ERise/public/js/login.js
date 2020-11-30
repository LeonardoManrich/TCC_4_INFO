    const URL = 'http://erise.com.br';
        $("#btn-register").click(function(e) {
            e.preventDefault();
              var formData = new FormData($('#eriseregister')[0]);
              console.log(formData)
              $.ajax({
                  url: URL + '/register/registerAccount',
                  type: 'POST',
                  data: formData,
                  dataType: 'json',
                  processData: false,
                  contentType: false,
                  success: function(response) {
                      console.log(response.message);
                      if (response.status != 0) {
                        $("input").removeClass('is-invalid').addClass('is-valid');
                          $('.help-block').html(response.message);
                          window.location.href = 'http://admin.erise.com.br/';
                      } else {
                          $("input").addClass('is-invalid').removeClass('is-valid');
                          $('.help-block').html(response.message);
                      }
                  },
                  error: function() {
                      console.log('erro');
                      $("input").addClass('is-invalid').removeClass('is-valid');
                  }
              });
          });
