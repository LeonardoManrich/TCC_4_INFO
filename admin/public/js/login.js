    const URL = 'http://admin.erise.com.br';
        $("#btn-login").click(function(e) {
          e.preventDefault();
            var formData = new FormData($('#eriselogin')[0]);
            console.log(formData)
            $.ajax({
                url: URL + '/login/logIn',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response.message);
                    if (response.status != 0) {
                        $("#email").addClass('is-valid').removeClass('is-invalid');
                        $("#password").addClass('is-valid').removeClass('is-invalid');
                        $('.help-block').html(response.message);
                        location.reload();
                    } else {
                        $("#email").addClass('is-invalid').removeClass('is-valid');
                        $("#password").addClass('is-invalid').removeClass('is-valid');
                        $('.help-block').html(response.message);
                    }
                },
                error: function() {
                    console.log(response);
                    $("#inputC").addClass('is-invalid').removeClass('is-valid');
                    $("#inputCc").addClass('is-invalid').removeClass('is-valid');
                }
            });
        });

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
                          window.location.href = URL + '/CreateStore';
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

          $("#btn-create-store").click(function(e) {
            e.preventDefault();
              var formData = new FormData($('#erisecreatestore')[0]);
              console.log(formData)
              $.ajax({
                  url: URL + '/createstore/create',
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
                        window.location.href = URL + '/';
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
