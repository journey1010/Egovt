//Enviar datos del login. 
$(document).ready(function() {
    $('#myForm').submit(function(event) {
      event.preventDefault(); 
  
      if (!$('#inputFirstName').val() || !$('#inputChoosePassword').val() || !$('#flexSwitchCheckChecked').prop('checked')) {
        ohSnap('Por favor ingrese todos los datos requeridos', {'color':'red'});
        return;
      }
  
      var username = $('#inputFirstName').val();
      var password = $('#inputChoosePassword').val();

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