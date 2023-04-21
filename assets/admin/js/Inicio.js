import { Toast } from "./Toast.js";

function comprobarCampos() {
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
                    icon: "success",
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
    $("#editGobernador").click( function () {
        if(comprobarCampos()) {
            enviarDatosGobernador();
        }
    });
});