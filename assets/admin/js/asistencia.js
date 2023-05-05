import { Toast } from './Toast.js';

$(document).ready(select2);
function select2() {
  $(".select2").select2({
    closeOnSelect: true,
  });
}

$(document).on('submit', '#registrarArchivoAsistencias', function (event) {
  event.preventDefault();
  if ($("#archivoAsistencias").prop("files").length !== 0) {
    let formData = new FormData();
    formData.append('archivo', $("#archivoAsistencias").prop("files")[0]);

    let progressBar = $('.progress-bar');
    let progressText = $('.progress-bar').text();
    $.ajax({
      url: '/administrador/rr-hh/load-file',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (evt) {
          if (evt.lengthComputable) {
            let percentComplete = evt.loaded / evt.total * 100;
            progressBar.css('width', percentComplete + '%');
            progressBar.text(percentComplete.toFixed(2) + '%');
          }
        }, false);
        return xhr;
      },
      beforeSend: function () {
        if ($('#reasignacion-registros-marcacion').is(':visible')) {
          $('#reasignacion-registros-marcacion').hide();
        }
        if ($('#registro-marcacionn').is(':visible')) {
          $('#registro-marcacion').hide();
        }
        progressBar.css('width', '0%');
        progressBar.text('0%');
      },
      success: function (response) {
        let resp = JSON.parse(response);
        if (resp.status === "success") {
          Toast.fire({
            icon: "success",
            title: resp.message,
          });
          let archivo = resp.archivo;
          registroMarcacion(archivo);
        } else {
          Toast.fire({
            icon: "warning",
            title: resp.message,
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: "#ff0000",
        });

      },
      complete: function () {
        progressBar.css('width', '100%');
        progressBar.text('100%');
      }
    });
  } else {
    Toast.fire({
      icon: "warning",
      title: 'Por favor, tiene que ingresar un archivo.',
    });
  }
});


function registroMarcacion(file) {
  let progressBar = $('#registro-marcacion .progress-bar');
  $('#registro-marcacion').show();
  let maxProgress = Math.floor(Math.random() * 59) + 2; // Generar número aleatorio entre 2 y 60
  let currentProgress = 0;
  let progressInterval = setInterval(function () {
    if (currentProgress < maxProgress) {
      currentProgress++;
      progressBar.css('width', currentProgress + '%');
      progressBar.text(currentProgress + '%');
    } else {
      clearInterval(progressInterval);
    }
  }, 50);

  $.ajax({
    url: '/administrador/rr-hh/read-excel',
    method: 'POST',
    data: { file: file },

    success: function (response) {
      clearInterval(progressInterval);
      progressBar.css('width', '100%');
      progressBar.text('100%');
      let resp = JSON.parse(response);
      Toast.fire({
        icon: "success",
        title: resp.message,
      });
      filtradoExcel();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Toast.fire({
        icon: "error",
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        background: "#ff0000",
      });
    }
  });
}


function filtradoExcel() {
  let progressBar = $('#reasignacion-registros-marcacion .progress-bar');
  $('#reasignacion-registros-marcacion').show();
  let maxProgress = Math.floor(Math.random() * 59) + 2; // Generar número aleatorio entre 2 y 60
  let currentProgress = 0;
  let progressInterval = setInterval(function () {
    if (currentProgress < maxProgress) {
      currentProgress++;
      progressBar.css('width', currentProgress + '%');
      progressBar.text(currentProgress + '%');
    } else {
      clearInterval(progressInterval);
    }
  }, 50);

  $.ajax({
    url: '/administrador/rr-hh/filtrar-excel',
    method: 'POST',
    success: function (response) {
      clearInterval(progressInterval);
      progressBar.css('width', '100%');
      progressBar.text('100%');
      let resp = JSON.parse(response);
      Toast.fire({
        icon: "success",
        title: resp.message,
      });
    },
    error: function (jqXHR, textStatus, errorThrown) {
      Toast.fire({
        icon: "error",
        title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
        background: "#ff0000",
      });
    }
  });
}


$(document).on('click', '#limpiarFiltroAsistencia', limpiarFiltro);
function limpiarFiltro() {
  document.getElementById("orderByAsistencia").selectedIndex = 0;
  document.getElementById("fechaAsistencia").value = "";
  document.getElementById("oficinaAsistencia").selectedIndex = 0;
  document.getElementById("palabraClaveAsistencia").value = "";
  $('#orderByAsistencia').select2('destroy');
  $('#oficinaAsistencia').select2('destroy');
  $(".select2").select2({
    closeOnSelect: true,
  });
}

$(document).on('click', '#aplicarFiltroAsistencia', searchMarcacion);
$(document).on('click', '#buscarIdEmpleado', searchMarcacion);
$(document).on('keydown', '#palabraClaveAsistencia', function (e) {
  if (e.keyCode === 13) {
    searchObra();
    return false;
  }
});

function searchMarcacion() {
  if (
    $('#oficinaAsistencia option:selected').val() == '' &&
    $('#fechaAsistencia').val() == '' &&
    $('#palabraClave').val() == '' 
  ) {
    Toast.fire({
      icon: "warning",
      title: 'Por favor, ingrese una palabra clave, una fecha o un oficina para iniciar una búsqueda.',
    });
  } else {
    let formData = {
      oficina: $('#oficinaAsistencia option:selected').val(),
      fecha: $('#fechaAsistencia').val(),
      ordenar: $('#orderByAsistencia').val(),
      palabra: $('#palabraClaveAsistencia').val(),
      tipoMarcacion: $('#tipoMarcacionAsistencia').val()
    }

    let progressBar = $('#reporte-marcacion .progress-bar');
    $('#reporte-marcacion').show();
    let maxProgress = Math.floor(Math.random() * 59) + 2; 
    let currentProgress = 0;
    let progressInterval = setInterval(function () {
      if (currentProgress < maxProgress) {
        currentProgress++;
        progressBar.css('width', currentProgress + '%');
        progressBar.text(currentProgress + '%');
      } else {
        clearInterval(progressInterval);
      }
    }, 50);

    $.ajax({
      url: '/administrador/rr-hh/buscar-asistencia',
      method: 'POST',
      data: formData,
      beforeSend: function (){
        if ($('#respuestaBusquedaAsistencias').is(':visible')) {
          $('#respuestaBusquedaAsistencias').hide();
        }
      },
      success: function (data) {
          let resp = JSON.parse(data);
          if (resp.status ==='success') {
            Toast.fire({
              icon: "success",
              title: resp.message,
            });
            clearInterval(progressInterval);
            progressBar.css('width', '100%');
            progressBar.text('100%');
            $('#respuestaBusquedaAsistencias').show();
            $('#respuestaBusquedaAsistencias').html('<a href="' + resp.archivo+'" download><button type="button" class="btn btn-block btn-outline-success"><i class="fa fa-download"></i> DESCARGAR REPORTE DE MARCACIONES</button></a>');
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        Toast.fire({
          icon: "error",
          title: `Ha ocurrido un error en la solicitud! Código: ${jqXHR.status}, Estado: ${textStatus}, Error: ${errorThrown}`,
          background: "#ff0000",
        });
      }
    });
  }
}