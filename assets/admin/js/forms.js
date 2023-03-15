$(document).ready(function (){

    //buscar dni 
    /*const btnDNI = document.getElementById('BuscarDNI');
    btnDNI.addEventListener('click', BuscarDNI);
    function BuscarDNI()
    {
      var numeroDNI = $('#dni').val();
      alert(numeroDNI);
      if ($.trim(numeroDNI) == ''){
        isValid = false;
        ohSnap('Por favor ingrese el número de su DNI y vuelva a intentarlo', {'color':'red'});
      } else {
        isValid = true;
      }
          
      if (isValid){
        $.ajax({
          method: 'GET',
          url: "https://dniruc.apisperu.com/api/v1/dni/"+numeroDNI+"?token=8bb1d335dc684d6c54e94e6ba34654b9b926a7b436cf92046a514b7ee1898992",
          dataType: "json",
          beforeSend: function(){
            $('#dni').prop('disabled', true);
          },
          success: function (response){
            alert(response['nombres']);
          },
          error: function (xhr, status, error) {  
            $('#dni').prop('disabled', false);
            ohSnap('Ha ocurrido un error al enviar los datos', { 'color': 'red' });          
          }
        });
      }
    }
    //formulario  de registrar visitas
    /*$('#buscarDNI').submit(function(e){
        e.preventDefault();
        const numeroDNI = $('#dni').val();
      
        if (numeroDNI == ''){
          isValid = false;
          ohSnap('Por favor ingrese todos los datos', {'color':'red'});
        } else {
          isValid = true;
        }
      
        if (isValid){
          $.ajax({
            type: "GET",
            url: "https://dniruc.apisperu.com/api/v1/dni/"+ numeroDNI +"?token=8bb1d335dc684d6c54e94e6ba34654b9b926a7b436cf92046a514b7ee1898992",
            dataType: "json",
            beforeSend: function() {
              $('#dni').prop('disabled', true);
            },
            success: function (response) {
              $("#nombres").val(response['nombres']);
              $("#apellidoPaterno").val(response['apellidoPaterno']);
              $("#apellidoMaterno").val(response['apellidoMaterno']);
              $('#dni').prop('disabled', false);
            },
            error: function (xhr, status, error) {  
              $('#dni').prop('disabled', false);
              ohSnap('Ha ocurrido un error al enviar los datos', { 'color': 'red' });          
            }
          });
        }
    });
    */
    
});