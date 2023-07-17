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
    let valorCampo = '';
    if (campo === 'descripcionConvocatoria') {
      valorCampo = quill.getText().trim();
    } else if (campo === 'archivosConvocatorias') {
      valorCampo = $('#' + campo)[0].files;
    }
    
    if (campo === 'descripcionConvocatoria' && valorCampo.length === 0) {
      Toast.fire({
        icon: 'warning',
        title: 'Debe completar todos los campos obligatorios'
      });
      enviarDatos = false;
    } else if (campo === 'archivosConvocatorias' && (!valorCampo || valorCampo.length === 0)) {
      Toast.fire({
        icon: 'warning',
        title: 'Debe seleccionar al menos un archivo en el campo de archivos'
      });
      enviarDatos = false;
    }
  });
  

  const extensionesPermitidas = ['docx', 'xlsx', 'xls', 'pdf', 'txt', 'doc'];
  const pesoMaximoArchivos = 50 * 1024 * 1024;
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
    let descripcion = quill.root.innerHTML;
    let formData = new FormData();
    let dependencias =  $('#dependenciaConvocatoria').val();
    formData.append('tituloConvocatoria', $('#tituloConvocatoria').val());
    formData.append('fechaInicioConvocatoria', $('#fechaInicioConvocatoria').val());
    formData.append('fechaLimiteConvocatoria', $('#fechaLimiteConvocatoria').val());
    formData.append('fechaFinalConvocatoria', $('#fechaFinalConvocatoria').val());
    for(var i=0; i < dependencias.length; i++){
      formData.append('dependenciaConvocatoria[]', dependencias[i]);
    }
    formData.append('descripcionConvocatoria', descripcion);

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

  let progressBar = $('.progress-bar');
  let progressBarContainer = $('.progress-bar-container');
  $.ajax({
    url: '/administrador/convocatoria/edit-convocatoria',
    method: 'POST',
    data: {
      id: id,
    },
    beforeSend: function (){
        progressBar.width('0%');
        progressBarContainer.show();
    },
    success: function(response){
      let resp = JSON.parse(response);
      if(resp.status === 'success'){
        $('#contentPage').html(resp.data);
        $('#contentPage').append("<script>$('.select2').select2({closeOnSelect: true });</script>");
      } else {
        Toast.fire({
          icon: 'error',
          title: 'Error inesperado en la ejecución de consulta. Contacte con soporte o vuelva a intentarlo. '
        });
      }   
    }, 
    xhr: function() {
      var xhr = new XMLHttpRequest();
      xhr.addEventListener('progress', function(event) {
        if (event.lengthComputable) {
          var percentComplete = (event.loaded / event.total) * 100;
          progressBar.css('width', percentComplete + '%');
        }
      }, false);
      return xhr;
    },
    complete: function() {
      progressBarContainer.hide();
    }, 
    error: function (jqXHR, textStatus, errorThrown) {
      Toast.fire({
        icon: "error",
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
      });
    },
  });
});

$(document).on('click', '.edit-adjunto', function(){
  let rowAdjunto = $(this).closest('tr');
  rowAdjunto.find('td[contenteditable=false]').prop('contenteditable', true);
  rowAdjunto.find('td:eq(1)').css('border-color', 'blue');
  rowAdjunto.find('.imgadjunto').prop('disabled', false);
  rowAdjunto.find('.edit-adjunto').hide();
  rowAdjunto.find('.cancel-adjunto').show();
  rowAdjunto.find('.save-adjunto').show();
});

$(document).on('click', '.cancel-adjunto', configSaveCancel);

$(document).on('click', '.save-adjunto', function(){
  configSaveCancel.bind(this)();
  let rowAdjunto = $(this).closest('tr');

  let formData = new FormData();
  formData.append('id',  rowAdjunto.find('td:eq(0)').text());
  formData.append('nombre', rowAdjunto.find('td:eq(1)').text());
  formData.append('archivo', rowAdjunto.find('.imgadjunto').prop('files')[0]);

  if( rowAdjunto.find('td:eq(1)').text() == ''){
    Toast.fire({
      icon: "warning",
      title: "El campo nombre no debe estar vacío."
    });
  } else{
    $.ajax({
      url: '/administrador/convocatoria/zona-editor/save-adjunto',
      method: 'POST',
      data: formData,
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(resp){
        if(resp.status === 'success'){
          Toast.fire({
            icon: 'success',
            title:  resp.message
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        });
      }
    });
  }
});

function configSaveCancel(){
  let rowAdjunto = $(this).closest('tr');
  rowAdjunto.find('td[contenteditable=true]').prop('contenteditable', false);
  rowAdjunto.find('td:eq(1)').css('border-color', 'transparent');
  rowAdjunto.find('.imgadjunto').prop('disabled', false);
  rowAdjunto.find('.edit-adjunto').show();
  rowAdjunto.find('.cancel-adjunto').hide();
  rowAdjunto.find('.save-adjunto').hide();
}

$(document).off('click', '.insert-adjunto').on('click', '.insert-adjunto', function(){
  let uniqueIdConvo = 'file-conv'+Date.now();
  let newRowConvo = `
  <tr>
    <td></td>
    <td style="max-width:150px"></td>
    <td style="max-width:150px">
    </td>
    <td class="text-left">
        <div class="custom-file">
            <input type="file" class="custom-file-input imgadjunto" id="${uniqueIdConvo}" onchange= "
                let input = $(this).closest('tr').find('.custom-file-label');
                if (this.files.length > 0) { 
                    input.html(this.files[0].name);
                } else {
                    input.html('Seleccione un archivo');
                }
            ">
            <label class="custom-file-label text-left" for="${uniqueIdConvo}" data-browse="Archivo"></label>
        </div>
    </td>
    <td class="text-right py-0 align-middle">
        <div class="btn-group btn-group-sm">
            <a class="btn btn-danger save-adjunto-new" alt="Guardar adjunto" title="Guardar cambios"><i class="fas fa-save"></i></a>
            <a class="btn btn-danger delete-adjunto-new" alt="eliminar adjunto" title="Eliminar adjunto"><i class="fas fa-trash-alt"></i></a>
        </div>
    </td>
  </tr>
  `;
  $('.table-adjunto tbody').append(newRowConvo);
});

$(document).on('click', '.save-adjunto-new', function(){
  let rowSaveNewAdjunto = $(this).closest('tr');
  let formData = new FormData();
  formData.append('archivo', rowSaveNewAdjunto.find('.imgadjunto').prop('files')[0]);
  formData.append('id', $('#idConvocatoria').val());
  
  let estado = true;

  if (rowSaveNewAdjunto.find('.imgadjunto').prop("files").length == 0){
    estado = false;
  }

  if(estado){
    $.ajax({
      url: '/administrador/convocatoria/zona-editor/save-new-adjunto',
      method: 'POST',
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      data: formData,
      success: function(response){
        let resp = JSON.parse(response);
        if(resp.status === 'success'){
          Toast.fire({
            icon: 'success',
            title: resp.message 
          });
        } else {
          Toast.fire({
            icon: 'warning',
            title: resp.message
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        Toast.fire({
          icon: 'error',
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`
        });
      }
    });
  } else {
    Toast.fire({
      icon: 'info',
      title: 'No puede guardar sin antes cargar un archivo.'
    });
  }
});

$(document).on('click', '.delete-adjunto-new', function(){
  let rowCancelNewAdjunto = $(this).closest('tr');
  rowCancelNewAdjunto.remove();
});

$(document).on('click', '#saveGeneralDatos', function(){
  let camposImportante = {
    'tituloConvocatoria': 'titulo',
    'descripcionConvocatoria': 'descripcion',
    'dependenciaConvocatoria': 'dependencia',
    'fechaRegistroConvocatoria': 'fecha_registro',
    'fechaLimiteConvocatoria': 'fecha_limite',
    'fechaFinalConvocatoria': 'fecha_finalizacion'
  };
  let camposLlenos = true;
  
  for (let clave in camposImportante) {
    if (clave === 'descripcionConvocatoria') {
      let descripcion = editor.getText().trim();
  
      if (descripcion === '') {
        Toast.fire({
          icon: 'warning',
          title: 'El campo ' + camposImportante[clave] + ' no debe estar vacío.'
        });
        camposLlenos = false;
        return false;
      }
    } else {
      if ($('#' + clave).val() === '') {
        Toast.fire({
          icon: 'warning',
          title: 'El campo ' + camposImportante[clave] + ' no debe estar vacío.'
        });
        camposLlenos = false;
        return false;
      }
    }
  }
 
  if(camposLlenos){
    let formData = {};
    for (let clave in camposImportante) {
      if (clave === 'descripcionConvocatoria') {
        formData[camposImportante[clave]] = editor.root.innerHTML;
      } else {
        formData[camposImportante[clave]] = $('#' + clave).val();
      }
    }
    
    formData['id'] = $('#idConvocatoria').val();
    $.ajax({
      url: '/administrador/convocatoria/zona-editor/update-general-datos',
      method: 'POST',
      data: formData,
      dataType: 'json',
      beforeSend: function(){
        $('#saveGeneralDatos').html("Guardar");
      },
      success: function(response){
        $('#saveGeneralDatos').html("Guardar");
        if(response.status === 'success'){
          Toast.fire({
            icon: 'success',
            title: response.message, 
          });
        } else{
          Toast.fire({
            icon: 'warning',
            title: response.message
          });
        } 
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $('#saveGeneralDatos').html("Guardar");
        Toast.fire({
            icon: "error",
            title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        });
    }
    });
  }
});