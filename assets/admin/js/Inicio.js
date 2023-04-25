import { Toast } from "./Toast.js";

function comprobarCamposGobernador() {
    let camposEdit = ['titulo', 'mensajeGobernador', 'fraseGobernador', 'entradaGobernador'];
    let camposLlenos = true;
    $.each(camposEdit, function (indice, valor) {
        if ($('#' + valor).val() == '') {
            Toast.fire({
                icon: "warning",
                title: "El campo " + valor + " no debe estar vacío"
            });
            camposLlenos = false;
            return false;
        }
    });
    return camposLlenos;
}


function enviarDatosGobernador() {
    let formData = new FormData();
    formData.append('titulo', $('#titulo').val());
    formData.append('mensaje', $('#mensajeGobernador').val());
    formData.append('frase', $('#fraseGobernador').val());
    formData.append('entrada', $('#entradaGobernador').val());
    formData.append('imgGobernador', $("#imgGobernador").prop("files")[0]); 

    $.ajax({
        method : 'POST',
        url: '/administrador/pagina-principal/datos-gobernador',
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        success: function (response) {
            let resp = JSON.parse(response);
            if (resp.status=== "success") {
                Toast.fire({
                  icon: "success",
                  title: resp.message,
                });
            } else  {
                Toast.fire({
                    icon: "error",
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
        }
    });
}

$(document).ready(function () {
    $(document).on('click', '#editGobernador', function () {
        if(comprobarCamposGobernador()) {
            enviarDatosGobernador();
        }
    });

    $(document).on('click', '.imagen-link', function(e) {
        e.preventDefault();
        let  fila = $(this).closest('tr');
        let  modal = fila.find('.imagen-modal');
        modal.modal('show');
    });

    $(document).on('click', '.edit-link', function () {
        let row =  $(this).closest("tr");
        row.find("td[contenteditable=false]").prop("contenteditable", true);
        row.find(".edit-link").hide();
        row.find(".cancel-link").show();
        row.find(".save-link").show();
    });

    $(document).on('click', '.cancel-link',  function () {
        let row =  $(this).closest("tr");
        row.find("td[contenteditable=true]").prop("contenteditable", false);
        row.find(".edit-link").show();
        row.find(".cancel-link").hide();
        row.find(".save-link").hide();
    });

    $(document).on('click', '.save-link', function () {
        let camposLlenos = true;
        let row =  $(this).closest("tr");
        row.find("td[contenteditable=true]").prop("contenteditable", false);
        row.find(".edit-link").show();
        row.find(".cancel-link").hide();
        row.find(".save-link").hide();

        if(row.find("td:eq(0)").text() == '' || row.find("td:eq(2)").text() == '' ) {
            Toast.fire({
                icon: "warning",
                title: "El campo descripción no debe estar vacío"
            });
            camposLlenos = false;
        }

        if (row.find('.imgBanner').prop("files") !== undefined && row.find('.imgBanner').prop("files")[0] !== undefined) {
            if (row.find('.imgBanner').prop("files")[0].size > 1024 * 1024) {
                Toast.fire({
                    icon: "warning",
                    title: "El tamaño de archivo no debe exceder 1MB"
                });
                camposLlenos = false;
            }
        }

        if (camposLlenos) {
            let formData = new FormData();
            formData.append('id', row.find("td:eq(0)").text());
            formData.append('archivo', row.find('.imgBanner').prop("files")[0]);
            formData.append('descripcion', row.find("td:eq(2)").text());

            $.ajax({
                method: 'POST',
                url: '/administrador/pagina-principal/datos-banner', 
                data : formData,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                success: function (response) {
                    let resp = JSON.parse(response);
                    if (resp.status=== "success") {
                        Toast.fire({
                          icon: "success",
                          title: resp.message,
                        });
                    } else  {
                        Toast.fire({
                            icon: "error",
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
                }
            });
        }
    });
});