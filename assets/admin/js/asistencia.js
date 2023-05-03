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
          } else  {
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