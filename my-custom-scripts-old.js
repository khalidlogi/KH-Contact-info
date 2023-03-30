jQuery(document).ready(function($) {
    $('#user-form').on('submit', function(e) {
        e.preventDefault();

        console.log(MyCustomScriptsData.ajax_url); // Will output the 'ajax_url' value from PHP
        console.log(MyCustomScriptsData.nonce); // Will output the 'nonce' value from PHP
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'my_user_insert',
                name: $('#user-form input[name="name"]').val(),
                email: $('#user-form input[name="email"]').val(),
                phone: $('#user-form input[name="phone"]').val(),
                city: $('#user-form input[name="city"]').val(),
            },
            success: function(response) {

                console.log('response.status ' + response.status);
              
                if(!response.status){
                    $('#response').removeClass('alert-success').addClass('alert-danger');
                    $('#response').html(response.message);
                }
                else{
               $('#response').removeClass('alert-danger').addClass('alert-success');
               //$('#user-form')[0].reset();
               //alert(response.message);
               $('#response').html(response.message + response.name);
               console.log(response.status);

                }
               console.log(response);
            },
            error:function(error){
                $('#response').html(response.message);
                console.log('response.status ' + response.status);

              console.log(error);  
            }
        });
    });
});



