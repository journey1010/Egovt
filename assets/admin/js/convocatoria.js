import { Toast } from "./Toast.js";

$(document).ready(select2);
function select2() {
  $(".select2").select2({
    closeOnSelect: true,
  });
}

$(document).on('submit', '#registrarConvocatoria', function(){
  let camposRequeridos = [
    'tituloConvocatoria', 
    'fechaInicioConvocatoria', 
    'fechaLimiteConvocatoria', 
    'fechaFinalConvocatoria', 
    'dependenciaConvocatoria',
    'archivosConvocatorias'
  ];
  let enviarDatos= true;
  
  $.each(camposRequeridos, function(index, value ){
    if($('#'+value).val() ===''){
      Toast.fire({
        icon: 'warning',
        message: 'Debe completar todos los campos obligatorios'
      });
      enviarDatos= false; 
    }
  });

  if(enviarDatos){
    let formData={
      tituloConvocatoria : $('#tituloConvocatoria').val(),
      fechaInicioConvocatoria : $('#fechaInicioConvocatoria').val(), 
      fechaLimiteConvocatoria : $('#fechaLimiteConvocatoria').val(), 
      fechaFinalConvocatoria : $('#fechaFinalConvocatoria').val(), 
      dependenciaConvocatoria : $('#dependenciaConvocatoria').val(),
      archivosConvocatorias : $('#archivosConvocatorias').val()
    };

    $.ajax({
      url: '/administrador/convocatoria/registro-convocatoria',
      method: '',
      data: formData,
      beforeSend: function(){

      },
      success: function(response){
        let resp = JSON.parse(response);
        if(resp.status === 'success'){
          Toast.fire({
            icon: 'success',
            title: resp.message
          });
        } else  {
          Toast.fire({
            icon: 'warning',
            title: resp.message
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! codigo: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown} `
        });
      }
    });
  }
});