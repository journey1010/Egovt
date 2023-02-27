//Enviar datos del login. 
$(document).ready(function(){
    $('form').submit(function(e){
        e.preventDefault();
        var username = $('#inputFirstName').val();
        var password = $('#inputChoosePassword').val();
        var terms = $('#flexSwitchCheckChecked').is(":checked");
        $.ajax({
            method: "POST",
            url: '/administrador/processlogin',
            data: { username: username, password: password},
            success: function(response) {
              var objResponse = JSON.parse(response);
              if(objResponse['success']==true ){
                window.location.href=objResponse['redirect'];
              }else{
                ohSnap(objResponse['error'], { 'color': 'red' });
                $("#submitButton").prop("disabled", false);
              }
              
          },
            error: function (xhr, status, error) {
              $("#submitButton").prop("disabled", false);
              ohSnap('Ha ocurrido un error al enviar los datos', { 'color': 'red' });          
            }
          });
    });
});

