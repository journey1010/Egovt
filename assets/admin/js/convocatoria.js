import { Toast } from "./Toast.js";

$(document).ready(select2);
function select2() {
  $(".select2").select2({
    "closeOnSelect": true,
  });
}

$(document).on("change", "#fechaInicioConvocatoria", function() {
  var fechaInicio = $(this).val();
  var fechaLimite = $("#fechaLimiteConvocatoria");
  var fechaFinal = $("#fechaFinalConvocatoria");

  fechaLimite.prop("disabled", false);
  fechaLimite.prop("min", fechaInicio);

  if (fechaLimite.val() < fechaInicio) {
    fechaLimite.val(fechaInicio);
  }

  fechaFinal.val("");
  fechaFinal.prop("disabled", true);
});

$(document).on("change", "#fechaLimiteConvocatoria", function() {
  var fechaLimite = $(this).val();
  var fechaFinal = $("#fechaFinalConvocatoria");

  fechaFinal.prop("disabled", false);
  fechaFinal.prop("min", fechaLimite);

  if (fechaFinal.val() < fechaLimite) {
    fechaFinal.val(fechaLimite);
  }
});

$(document).on('submit', '#registrarConvocatoria', function(event){
  event.preventDefault();
  const camposRequeridos = [
    'tituloConvocatoria',
    'fechaInicioConvocatoria',
    'fechaLimiteConvocatoria',
    'fechaFinalConvocatoria',
    'dependenciaConvocatoria',
    'archivosConvocatorias',
    'descripcionConvocatoria'
  ];
  
  let enviarDatos = true;
  camposRequeridos.forEach(campo => {
    if ($('#' + campo).val() === '') {
      Toast.fire({
        icon: 'warning',
        title: 'Debe completar todos los campos obligatorios'
      });
      enviarDatos = false;
    }
  });

  const extensionesPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc'];
  const pesoMaximoArchivos = 10 * 1024 * 1024;
  let archivosConvocatorias = $('#archivosConvocatorias')[0].files;

  for (const key in archivosConvocatorias) {
    if (archivosConvocatorias.hasOwnProperty(key)) {
      const file = archivosConvocatorias[key];
      const archivoNombre = file.name;
      const fileExtension = archivoNombre.split('.').pop().toLowerCase();
    
      if (!extensionesPermitidas.includes(fileExtension)) {
        Toast.fire({
          icon: 'warning',
          title: 'Extensión no permitida. Solo se permiten archivos de tipo: docx, xlsx, xls, pdf, txt, doc'
        });
        enviarDatos = false;
        return;
      }
    
      if (file.size > pesoMaximoArchivos) {
        Toast.fire({
          icon: 'warning',
          title: 'El archivo no debe superar los 10 MB'
        });
        enviarDatos = false;
        return;
      }
    }
  }
  
  if(enviarDatos){
    let formData = new FormData();
    formData.append('tituloConvocatoria', $('#tituloConvocatoria').val());
    formData.append('fechaInicioConvocatoria', $('#fechaInicioConvocatoria').val());
    formData.append('fechaLimiteConvocatoria', $('#fechaLimiteConvocatoria').val());
    formData.append('fechaFinalConvocatoria', $('#fechaFinalConvocatoria').val());
    formData.append('dependenciaConvocatoria', $('#dependenciaConvocatoria').val());
    formData.append('descripcionConvocatoria', $('#descripcionConvocatoria').val());

    for(let i =0;  i <= archivosConvocatorias.length - 1; i++){
      formData.append('archivosConvocatorias['+i+']',  archivosConvocatorias[i]);
    }

    const progressBar = $('.progress-bar');
    let totalFiles = 0;
    let progresoActual= 0;

    progressBar.css('witdh', '0%').attr('aria-valuenow', 0).text('0%');
    for(let i = 0; i < archivosConvocatorias.length; i++){
      totalFiles += archivosConvocatorias[i].size;
    }

    $.ajax({
      url: '/administrador/convocatoria/registro-convocatoria',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function(){
        $('#guardarConvocatoria').html('Guardando');
        $('#guadarConvocatoria').prop('disabled', true);
      },
      xhr: function(){
        let xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(e){
          if(e.lengthComputable){
            let porcentaje = Math.round((e.loaded/totalFiles)*100);
            progressBar.css('width', porcentaje + '%').attr('aria-valuenow', porcentaje).text(porcentaje + '%');
            progresoActual = porcentaje;
          }
        }, false);
        return xhr;
      }, 
      success: function(response){
        $('#guardarConvocatoria').html('Guardar');
        $('#guardarConvocatoria').prop('disabled', false);
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
        $('#guardarConvocatoria').html('Guardar');
        $('#guardarConvocatoria').prop('disabled', false);
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown} `
        });
      },
      complete: function(){
        progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');
      }
    });
  }
});

$(document).on('click', '.edit-ico-upconv', function(){
  let row = $(this).closest("tr");
  let id = row.find("td:eq(0)").text();
  $.ajax({
    url: '/administrador/convocatoria/edit-convocatoria',
    method: 'POST',
    data: {
      id: id,
    },
    beforeSend: function (){

    },
    success: function(response){
      let resp = JSON.parse(response);
      if(resp.status === 'success'){

      } else {
        Toast.fire({
          icon: 'error',
          title: 'Error inesperado en la ejecución de consulta. Contacte con soporte o vuelva a intentarlo. '
        });
      }
      
    }, 
    error: function (jqXHR, textStatus, errorThrown) {
      Toast.fire({
        icon: "error",
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
      });
    },
  });
});